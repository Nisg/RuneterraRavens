<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $primaryKey = 'summonerId';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function participants() 
	{
		return $this->hasMany('Participant','summonerId','summonerId')->orderBy('matchId','desc');
	}

	public function stats()
	{
		return $this->hasManyThrough('ParticipantStat','Participant','summonerId','participantTableId');
		return $this->participants()->join("participants_stats", "participants.id", "=", "participants_stats.participantTableId");
	}

	public function matches() 
	{
		return Match::join("participants","participants.matchId", "=", "matches.matchId")->where('participants.summonerId','=',$this->summonerId);
	//	return $this->hasManyThrough('Match','Participant','matchId','summonerId')->orderBy('matchId', 'desc');
	}

    public function getAverageStat($fields) 
    {
        $averages = array_fill_keys($fields, 0);

        foreach ($fields as $field){
        	$averages[$field]=round($this->stats()->avg($field),2);
        }

        return $averages;

    }

}
