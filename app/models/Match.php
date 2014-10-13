<?php

class Match extends \Eloquent {
	protected $table="matches";

	protected $primaryKey = 'matchId';

	public function participants() 
	{
		return $this->hasMany('Participant','matchId','matchId')->orderBy('id', 'asc');
	}

	public function users()
	{
		return $this->hasManyThrough('User','Participant','summonerIds','matchId');
	}

	public function timeline()
	{
		return $this->hasMany('TimelineFrame','matchId','matchId')->orderBy('frameId','asc');
	}
	
	public function teams() 
	{
		return $this->hasMany('Team','matchId','matchId')->orderBy('teamId','asc');
	}
}
