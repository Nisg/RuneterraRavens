<?php

class Participant extends \Eloquent {
	protected $table = "participants";

	protected $primaryKey = 'id';

	// public function getForeignKey() 
	// {
	// 	return "matchId";
	// }

	public function getKeyName(){
		//Same as changing the primaryKey to matchId - not the greatest of fixes
		return 'matchId';
	}

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

	public function timeline()
	{
		return $this->hasManyThrough('TimelineFrame','Match','matchId','matchId');
	}

	public function events() {
		return $this->hasManyThrough('TimelineEvent','TimelineFrame','matchId','timelineFrameId')
			->where(function ($query) {
				$query->orWhere('participantId','=',$this->participantId);
				$query->orWhere('killerId','=',$this->participantId);
				$query->orWhere('victimId','=',$this->participantId);
				$query->orWhereHas('assistants', function($query) {
					$query->where('participantId','=',$this->participantId);
				});
			});
	}
}