<?php

class Participant extends \Eloquent {
	protected $table = "participants";

	protected $fillable = array('matchId','summonerId','summonerName','championId','spell1Id','spell2Id','teamId','role','lane');

	protected $primaryKey = 'id';

	// public function getForeignKey() 
	// {
	// 	return "matchId";
	// }

	// public function getKeyName(){
	// 	//Same as changing the primaryKey to matchId - not the greatest of fixes
	// 	return 'matchId';
	// }

	public function match()
	{
		return $this->belongsTo('Match','matchId','matchId');
	}

	public function user()
	{
		if ($this->summonerId)
			return $this->belongsTo('User','summonerId','summonerId');
		else
			return null;
	}

	public function stats()
	{
		return $this->hasOne('ParticipantStat','participantTableId','id');
	}

}