<?php
namespace Leona;

class DataDragon {

	public $image_path 			= "/img";
	public $champion_dir 		= "/champion";
	public $summoner_spell_dir 	= "/spell";
	public $spell_dir 		= "/spell";
	public $profile_icon_dir 	= "/profile";
	public $passive_dir 		= "/passive";
	public $mastery_dir			= "/mastery";
	public $rune_dir 			= "/rune";
	public $neutral_dir 		= "/neutral";

	public $mapIds = array(
		1 	=> 	"Summoner's Rift", 
		2 	=> 	"Summoner's Rift - Autumn Variant", 
		3 	=> 	"The Proving Grounds - Tutorial Map", 
		4 	=> 	"Twisted Treeline - Original Version", 
		8 	=> 	"The Crystal Scar", 
		10 	=> 	"Twisted Treeline", 
		12 	=> 	"Howling Abyss", 
		);

	public $gameTypes = array(
		'CUSTOM_GAME' 	=>	"Custom game",
		'TUTORIAL_GAME' =>	"Tutorial game",
		'MATCHED_GAME'	=>	"Matched game"
		);

	public $gameModes = array(
		'CLASSIC'		=>	"Classic Summoner's Rift and Twisted Treeline",
		'ODIN'			=>	"Dominion/Crystal Scar",
		'ARAM'			=>	"ARAM",
		'TUTORIAL'		=>	"Tutorial",
		'ONEFORALL'		=>	"One for all",
		'ASCENSION'		=>	"Ascension",
		'FIRSTBLOOD'	=>	"Snowdown Showdown",
		);

	public $queueTypes = array(
		'CUSTOM'					=>	"Custom",
		'NORMAL_5x5_BLIND'			=>	"Normal 5v5 Blind Pick",
		'NORMAL_5x5_DRAFT'			=>	"Normal 5v5 Draft Pick",
		'NORMAL_3x3'				=>	"Normal 3v3",
		'RANKED_SOLO_5x5'			=>	"Ranked Solo 5v5",
		'RANKED_PREMADE_3x3'		=>	"Ranked Premade 3v3",
		'RANKED_PREMADE_5x5'		=>	"Ranked Premade 5v5",
		'RANKED_TEAM_3x3'			=>	"Ranked Team 3v3",
		'RANKED_TEAM_5x5'			=>	"Ranked Team 5v5",
		'GROUP_FINDER_5x5'			=>	"Team Builder",
		'ARAM_5x5'					=>	"ARAM",
		'ODIN_5x5_BLIND'			=>	"Dominion 5v5 Blind Pick",
		'ODIN_5x5_DRAFT'			=>	"Dominion 5v5 Draft Pick",
		'ONEFORALL_5x5'				=>	"One for All ",
		'BOT_5x5'					=>	"Summoner's Rift Coop vs AI",
		'BOT_5x5_INTRO'				=>	"Summoner's Rift Coop vs AI Intro Bot",
		'BOT_5x5_BEGINNER'			=>	"Summoner's Rift Coop vs AI Beginner Bot",
		'BOT_5x5_INTERMEDIATE'		=>	"Summoner's Rift Coop vs AI",
		'BOT_TT_3x3'				=>	"Twisted Treeline Coop vs AI",
		'BOT_ODIN_5x5'				=>	"Dominion Coop vs AI",
		'FIRSTBLOOD_1x1'			=>	"Snowdown Showdown 1v1",
		'FIRSTBLOOD_2x2'			=>	"Snowdown Showdown 2v2",
		'SR_6x6'					=>	"Hexakill",
		'URF_5x5'					=>	"Ultra Rapid Fire",
		'BOT_URF_5x5'				=>	"Ultra Rapid Fire  played against AI",
		'NIGHTMARE_BOT_5x5_RANK1'	=>	"Doom Bots Rank 1",
		'NIGHTMARE_BOT_5x5_RANK2'	=>	"Doom Bots Rank 2",
		'NIGHTMARE_BOT_5x5_RANK5'	=>	"Doom Bots Rank 5",
		'ASCENSION'					=>	"Ascention",	
	);


	public function __construct()
	{
		//Path to the JSON data files
		$this->path = "data/";

		//This array contains the indexes of the maps which will be shown as options to the user (WHITELIST)
		$this->allowedMaps = array_fill_keys(
		array(
			1,
			10
		),0);

		//This array contains the indexes of the queue types which will be shown as options to the user (WHITELIST)
		$this->allowedQueueTypes = array_fill_keys(array(
		'NORMAL_5x5_BLIND',
		'NORMAL_5x5_DRAFT',	
		'NORMAL_3x3',	
		'RANKED_SOLO_5x5',
		'RANKED_PREMADE_3x3',
		'RANKED_PREMADE_5x5',
		'RANKED_TEAM_3x3',
		'RANKED_TEAM_5x5',	
		'GROUP_FINDER_5x5',
		), 0);

		return $this;
	}

	public function getMap($identifier)
	{
		if (is_numeric($identifier)) {
			if (array_key_exists($identifier, $this->mapIds))
				return $this->mapIds[$identifier];
			else
				return -1;
		}
		elseif ( ($index = array_search($identifier, $this->mapIds)) !== FALSE )
			return $this->mapIds[$index];
		else
			return -1;
	}

	public function getMaps() {
		return array_intersect_key($this->mapIds, $this->allowedMaps);
	}

	public function getGameType($identifier)
	{
		if (array_key_exists($identifier, $this->gameTypes))
			return $this->gameTypes[$identifier];
		else
			return -1;
	}

	public function getGameMode($identifier)
	{
		if (array_key_exists($identifier, $this->gameModes))
			return $this->gameModes[$identifier];
		else
			return -1;
	}

	public function getQueueType($identifier)
	{
		if (array_key_exists($identifier, $this->queueTypes))
			return $this->queueTypes[$identifier];
		else
			return -1;
	}

	public function getQueues() {
		return array_intersect_key($this->queueTypes, $this->allowedQueueTypes);
	}

	public function getAllChampions()
	{
		if (!isset($this->champData))
			$this->champData = json_decode(file_get_contents($this->path.'championFull.json'),true)['data'];
		$result = array();
		foreach ($this->champData as $champ) {
			$result[$champ['key']]=$champ['name'];
		}
		return $result;
	}

	public function getChampion($identifier, $is_name = false)
	{
		if (!isset($this->champData))
			$this->champData = json_decode(file_get_contents($this->path.'championFull.json'),true)['data'];
		if ($is_name) {
			foreach ($this->champData as $champ) {
				if ($champ['name']===$identifier)
					return $champ;
			}
		}
		else {
			foreach ($this->champData as $champ) {
				if ($champ['key']===(string)$identifier)
					return $champ;
			}
		}
		return -1;
	}

	public function getChampionName($identifier)
	{
		$result = $this->getChampion($identifier);
		if ( ($result!==1) && array_key_exists('name', $result) )
			return $result['name'];
		return -1;
	}

	public function getChampionImage($identifier)
	{
		$result = $this->getChampion($identifier);
		if ( ($result!==1) && array_key_exists('image', $result) )
			return $result['image']['full'];
		return -1;
	}

	public function getChampionImagePath($identifier)
	{
		$result = $this->getChampionImage($identifier);
		if ($result!==-1)
			return $this->image_path.$this->champion_dir."/".$result;
		return -1;
	}

	public function getSpell($championId,$identifier) {	
		if (!isset($this->champData))
			$this->champData = json_decode(file_get_contents($this->path.'championFull.json'),true)['data'];
		$champion = $this->getChampion($championId);
		if ($champion != -1)
		{
			foreach ($champion['spells'] as $spell) {
				if ($spell['id'] == $identifier)
					return $spell;
			}
			return -1;
		}
		return -1;
	}

	public function getSpellName($identifier)
	{
		$result = $this->getSpell($identifier);
		if ( ($result!==1) && array_key_exists('name', $result) )
			return $result['name'];
		return -1;
	}

	public function getSpellImage($identifier)
	{
		$result = $this->getSpell($identifier);
		if ( ($result!==1) && array_key_exists('image', $result) )
			return $result['image']['full'];
		return -1;
	}

	public function getSpellImagePath($identifier)
	{
		$result = $this->getSpellImage($identifier);
		if ($result!==-1)
			return $this->image_path.$this->spell_dir."/".$result;
		return -1;
	}

	public function getItem($identifier, $is_name = false)
	{
		if (!isset($this->itemData))
			$this->itemData = json_decode(file_get_contents($this->path.'item.json'),true)['data'];
		if ($is_name) {
			foreach ($this->itemData as $item) {
				if ($item['name']===$identifier)
					return $item;
			}
		}
		else if ($identifier == 0) {
			return 0;
		}
		else {
			return $this->itemData[$identifier];
		}
		return -1;
	}

	public function getItemName($identifier)
	{
		$result = $this->getSpell($identifier);
		if ( ($result!==1) && array_key_exists('name', $result) )
			return $result['name'];
		return -1;
	}

	public function getItemImage($identifier)
	{
		$result = $this->getSpell($identifier);
		if ( ($result!==1) && array_key_exists('image', $result) )
			return $result['image']['full'];
		return -1;
	}

	public function getItemImagePath($identifier)
	{
		$result = $this->getSpellImage($identifier);
		if ($result!==-1)
			return $this->image_path.$this->$item_dir."/".$result;
		return -1;
	}

	public function getMastery($identifier, $is_name = false)
	{
		if (!isset($this->masteryData))
			$this->masteryData = json_decode(file_get_contents($this->path.'mastery.json'),true)['data'];
		if ($is_name) {
			foreach ($this->masteryData as $mastery) {
				if ($mastery['name']===$identifier)
					return $mastery;
			}
		}
		else {
			foreach ($this->masteryData as $mastery) {
				if ($mastery['id']===$identifier)
					return $mastery;
			}
		}
		return -1;
	}

	public function getMasteryTree($identifier)
	{
		if (!isset($this->masteryTree))
			$this->masteryTree = json_decode(file_get_contents($this->path.'mastery.json'),true)['tree'];
		return $this->masteryTree[$identifier];
	}

	public function getProfileIcon($identifier)
	{
		if (!isset($this->profileiconData))
			$this->profileiconData = json_decode(file_get_contents($this->path.'profileicon.json'),true)['data'];
		foreach ($this->masteryData as $mastery) {
				if ($mastery['id']===$identifier)
					return $mastery;
			}
		return -1;
	}

	public function getRune($identifier, $is_name = false)
	{
		if (!isset($this->runeData))
			$this->runeData = json_decode(file_get_contents($this->path.'rune.json'),true)['data'];
		if ($is_name) {
			foreach ($this->runeData as $rune) {
				if ($rune['name']===$identifier)
					return $rune;
			}
		}
		else {
			foreach ($this->runeData as $key=>$value) {
				if ($key===$identifier)
					return $value;
			}
		}
		return -1;
	}

	public function getSummonerSpell($identifier, $is_name = false)
	{
		if (!isset($this->summonerSpellData))
			$this->summonerSpellData = json_decode(file_get_contents($this->path.'summoner.json'),true)['data'];
		if ($is_name) {
			foreach ($this->summonerSpellData as $summonerSpell) {
				if ($summonerSpell['name']===$identifier)
					return $summonerSpell;
			}
		}
		else {
			foreach ($this->summonerSpellData as $summonerSpell) {
				if ($summonerSpell['key']===(string)$identifier)
					return $summonerSpell;
			}
		}
		return -1;
	}

}