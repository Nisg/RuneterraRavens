<?php

class Match extends \Eloquent {
	protected $table="matches";

	protected $fillable=array('matchId','matchCreation','matchDuration','mapId','matchMode','matchType','matchVersion','queueType','region','season');

	protected $primaryKey = 'matchId';

	public function participants() 
	{
		return $this->hasMany('Participant','matchId','matchId')->orderBy('id', 'asc');
	}

	public function users()
	{
		return $this->hasManyThrough('User','Participant','summonerIds','matchId');
	}
}