<?php

class UserController extends \BaseController {

	private $totalMatches = 30;
	private $numberOfRecentMatches = 7;
	private $fields = array(
			'kills',
			'deaths',
			'assists',
			'minionsKilled',
			'goldEarned',
			'champLevel',
			'wardsPlaced',
			'totalDamageDealtToChampions',
			'totalDamageTaken'
			);


	public function ravenstorm()
	{
		return View::make('ravenstorm.index');
	}

	public function ravenstormUserList()
	{
		$users = User::paginate(10);
		return View::make('ravenstorm.userlist',array('users'=>$users));
	}

	public function ravenstormLeaderboards()
	{
		$users = User::orderBy('ravenscore','DESC')->paginate(10);
		return View::make('ravenstorm.leaderboards',array('users'=>$users));
	}

	public function ravenstormSearch()
	{
		$searchedSummonerName = Input::get('summonerName');
		$user = User::where('summonerName','=',$searchedSummonerName)->first();
		if ($user)
		{
			return Redirect::route('ravenstormUser',$user->summonerId);
		}
		else
		{
			return View::make('ravenstorm.error', array('error' => 'User not found, please try again!'));
		}
	}

	//Requires a collection of stats
	public function ravenscore($stats)
	{

		//This calculates a score following these rules

	    // Kill: 4 points
	    // Assist: 3 points
	    // Death: -2 points
	    // 1 CS: 0.03 points
	    // First blood: 4 points
	    // Quadra Kill: 10 points
	    // Penta Kill: 20 points
	    // More than 10 assists: 4 points
	    // Win: 5 points
	    // Player's team killed Baron Nashor: 6 points
	    // Player's team killed Dragon: 4 points
	    // Tower destroyed by player's team: 3 points

	    //Coefficients
	    $scoringCoefficients = array(
	    	'kill' => 4,
	    	'assist' => 3,
	    	'death' => -2,
	    	'cs' => 0.03,
	    	'fb' => 4,
	    	'quadra' => 10,
	    	'penta' => 20,
	    	'assistThreshold' => 10,
	    	'assistBonusPoints' => 4,
	    	'win' => 5,
	    	'nashor' => 6,
	    	'dragon' => 4,
	    	'tower' => 3
	    	);

	    $stats->each(function ($stat) use ($scoringCoefficients){
	    	$stat->ravenscore  = $stat->kills*$scoringCoefficients['kill'];
	    	$stat->ravenscore += $stat->assists*$scoringCoefficients['assist'];
	    	$stat->ravenscore += $stat->deaths*$scoringCoefficients['death'];
	    	$stat->ravenscore += $stat->minionsKilled*$scoringCoefficients['cs'];
	    	$stat->ravenscore += $stat->firstBlood*$scoringCoefficients['fb'];
	    	$stat->ravenscore += $stat->quadraKills*$scoringCoefficients['quadra'];
			$stat->ravenscore += $stat->pentaKills*$scoringCoefficients['penta'];
			if ($stat->assists>$scoringCoefficients['assistThreshold'])
				$stat->ravenscore+=$scoringCoefficients['assistBonusPoints'];
			$stat->ravenscore += $stat->winner*$scoringCoefficients['win'];
			// We can add this bit later
			// $stat->ravenscore += $stat->participant->match->teams[($stat->participant->teamId/100)-1]->baronKills*$scoringCoefficients['nashor'];
			// $stat->ravenscore += $stat->participant->match->teams[($stat->participant->teamId/100)-1]->dragonKills*$scoringCoefficients['dragon'];
			// $stat->ravenscore += $stat->participant->match->teams[($stat->participant->teamId/100)-1]->towerKills*$scoringCoefficients['tower'];
			if ($stat->ravenscore < 0 )
				$stat->ravenscore = 0;
		});

	    return $stats;
	}


	public function ravenstormUser($summonerId)
	{
		$user = User::find($summonerId);
		if (is_null($user))
		{
			return View::make('ravenstorm.error', array('error' => 'User not found, please try again!'));
		}
		$this->numberOfRecentMatches = 7;
		$this->totalMatches = 30;
		
		$stats = $user->stats()->with('participant.match')->limit($this->totalMatches)->get();
		JavaScript::put([
				'summonerId'=>$summonerId
				]);
		if (count($stats)<2)
		{
			
			//We have no matches or just one match which means the graph is useless so we should return the view as empty as possible
			return View::make('ravenstorm.user',
				array(
					'summonerName' => $user->summonerName)
				);
		}

		$stats = $this->ravenscore($stats);

		$chartData = $this->prepareChart($stats);

		//Pass them to Javascript
		JavaScript::put([
			'labels'=>$chartData['labels'],
			'datasets'=>$chartData['datasets'],
			'summonerId'=>$summonerId
			]);


		//Average calculation

		$averages = array(
			'total' => $user->getAverageStat($this->fields),
			'recent' => $this->calculateAverages($stats)
			);
		return View::make('ravenstorm.user',
			array(
				'stats' => $stats->take(-$this->numberOfRecentMatches)->reverse(),
				'averages'=>$averages,
				'fields'=>$this->fields,
				'ravenscore'=>round(array_sum($stats->lists('ravenscore')) / count($stats),2),
				'summonerName' => $user->summonerName)
		);
	}

	public function calculateAverages($stats)
	{
		$averages = array_fill_keys($this->fields, 0);

		//If recent is set we calculate an aditional set of averages for the recent n matches
		foreach ($stats as $stat_key => $stat_value) {
			foreach ($this->fields as $field_key => $field_value) {
        		if (isset($stat_value[$field_value]))
        			$averages[$field_value]+=$stat_value[$field_value]; 	
        	}
		}
		//calculate averages
		foreach ($averages as $key=>$value)
		{
			$averages[$key] = round($value/count($stats),2);
		}
		return $averages;
	}

	public function prepareChart($stats)
	{
		//Define labels
		$labels = array();
		foreach ($stats as $entry) {
		    $labels[] = app('DataDragon')->getChampion($entry->participant->championId)['name'];
		}

		//Define Dataset
		$datasets = array(
			//One element of array for each stat tracked
			array(
				'label'	=> "Ravenscore",
				'fillColor' => "rgba(117,107,177,0.2)",
        		'strokeColor' => "rgba(117,107,177,1)",
        		'pointColor' => "rgba(117,107,177,1)",
        		'pointStrokeColor' => "#fff",
        		'pointHighlightFill' => "#fff",
        		'pointHighlightStroke' => "rgba(117,107,177,1)",
        		'data' => $stats->lists('ravenscore')
				),
			array(
				'label'	=> "Kills",
				'fillColor' => "rgba(151,187,205,0.2)",
        		'strokeColor' => "rgba(151,187,205,1)",
        		'pointColor' => "rgba(151,187,205,1)",
        		'pointStrokeColor' => "#fff",
        		'pointHighlightFill' => "#fff",
        		'pointHighlightStroke' => "rgba(151,187,205,1)",
        		'data' => $stats->lists('kills')
				),
			array(
				'label'	=> "Deaths",
				'fillColor' => "rgba(189,189,189,0.2)",
        		'strokeColor' => "rgba(189,189,189,1)",
        		'pointColor' => "rgba(189,189,189,1)",
        		'pointStrokeColor' => "#fff",
        		'pointHighlightFill' => "#fff",
        		'pointHighlightStroke' => "rgba(189,189,189,1)",
        		'data' => $stats->lists('deaths')
				),
			array(
				'label'	=> "Assists",
				'fillColor' => "rgba(254,178,76,0.2)",
        		'strokeColor' => "rgba(254,178,76,1)",
        		'pointColor' => "rgba(254,178,76,1)",
        		'pointStrokeColor' => "#fff",
        		'pointHighlightFill' => "#fff",
        		'pointHighlightStroke' => "rgba(254,178,76,1)",
        		'data' => $stats->lists('assists')
				),
			array(
				'label'	=> "Creep Score",
				'fillColor' => "rgba(220,220,220,0.2)",
        		'strokeColor' => "rgba(220,220,220,1)",
        		'pointColor' => "rgba(220,220,220,1)",
        		'pointStrokeColor' => "#fff",
        		'pointHighlightFill' => "#fff",
        		'pointHighlightStroke' => "rgba(220,220,220,1)",
        		'data' => array_map(function($x){return round($x/100,2);},$stats->lists('minionsKilled'))
				),
			array(
				'label'	=> "Wards Placed",
				'fillColor' => "rgba(153,216,201,0.2)",
        		'strokeColor' => "rgba(153,216,201,1)",
        		'pointColor' => "rgba(153,216,201,1)",
        		'pointStrokeColor' => "#fff",
        		'pointHighlightFill' => "#fff",
        		'pointHighlightStroke' => "rgba(153,216,201,1)",
        		'data' => $stats->lists('wardsPlaced')
				)
			);
		return array('labels'=>$labels,'datasets'=>$datasets);
	}

	/*
	 *
	 * Return values:
	 * 1  - Not enough data found
	 * 2  - 30 minutes not passed
	 * 3  - Miner error
	 * 13 - User not found
	 *
	 */
	public function updateRecentMatches($summonerId)
	{
		$user = User::find($summonerId);
		if (is_null($user))
			return 13;
		//Don't update more than once per hour
		$format = 'Y-m-d h:i:s';
		if(strtotime($user->updated_at) > (time() -(0*60)) )
			return 2;
		$recentMatches = Miner::getRecentMatches($user);
		if (!(is_array($recentMatches)))
			return 3;
		//This can be made to use less queries
		foreach($recentMatches as $recentMatch){
			
			//Does the match exist?
			$match =Match::find($recentMatch['matchId']);
			if (is_null($match))
			{
				$newMatch = new Match;
				$newMatch->fill($recentMatch);
				$newMatch->save();
			}
				//Next up Participant!

			$newParticipant = Participant::where('matchId','=',$recentMatch['matchId'])->where('summonerId','=',$summonerId)->first();
			if (is_null($newParticipant))
			{
				$newParticipant = new Participant;
				$newParticipant->matchId=$recentMatch['matchId'];
				$newParticipant->summonerId=$summonerId;
				$newParticipant->fill($recentMatch['participants'][0]);
				$newParticipant->role=$recentMatch['participants'][0]['timeline']['role'];
				$newParticipant->lane=$recentMatch['participants'][0]['timeline']['lane'];
				$newParticipant->save();
			}

			//Next his stats
			$newParticipantStat = ParticipantStat::where('participantTableId','=',$newParticipant->id)->first();
			if (is_null($newParticipantStat))
			{
				$newParticipantStat = new ParticipantStat;
				$newParticipantStat->participantTableId =$newParticipant->id;
				$newParticipantStat->fill($recentMatch['participants'][0]['stats']);
				$newParticipantStat->save();
			}

			//We are done!
			
		}

		$stats = $user->stats()->with('participant.match')->limit($this->totalMatches)->get();
		
		if (count($stats)<2)
		{
			//We have no matches or just one match which means the graph is useless so we should return the view as empty as possible
			return 1;
		}

		$stats = $this->ravenscore($stats);
		$user->ravenscore = round(array_sum($stats->lists('ravenscore')) / count($stats),2);
		$user->save();

		$returnedStats = array();

		$recentMatchesStats = $stats->take(-$this->numberOfRecentMatches)->reverse();

		foreach ($recentMatchesStats as $stat) {
			array_push($returnedStats,array(
				'win'		=>	($stat->winner==1?'win':'loss'),
			    'champion'		=>	HTML::image(
			    	"/img/champion/".app('DataDragon')->getChampion($stat->participant->championId)['image']['full'],
			    	app('DataDragon')->getChampion($stat->participant->championId)['name']
			    	),
			    'kills'			=>	$stat->kills,
			    'assists'		=>	$stat->assists,
			    'deaths'		=>	$stat->deaths,
			    'ravenscore'	=>	$stat->ravenscore
				)
			);
		}

		$fieldNames = array();
		foreach ($this->fields as $field)
			$fieldNames[$field] = Lang::get('user.'.$field);

		return array(
			'chartData'	=>	$this->prepareChart($stats),
			//format stats to only show kills,deaths,assists,ravenscore and champimage with a link
			//then error checkingin the js
			'stats' 	=> $returnedStats,
			'fields' 	=> $fieldNames,
			'averages' 	=> array('total' 	=> $user->getAverageStat($this->fields),
								'recent' 	=> $this->calculateAverages($stats)
								)
			);
	}

}