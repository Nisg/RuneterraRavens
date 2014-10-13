<?php

class Team extends \Eloquent {
	protected $table="teams";

	protected $primaryKey = 'matchId';

	public function match()
	{
		return $this->belongsTo('Match','matchId','matchId');
	}

	public function participants() 
	{
		return $this->hasManyThrough('Participant','Match','matchId','matchId')->where('teamId','=',$this->teamId);
	}
}
