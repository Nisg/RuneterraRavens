<?php

class TimelineFrame extends \Eloquent {
	protected $table="timeline_frames";

	protected $primaryKey = 'id';

	// public function getKeyName(){
	// 	//Same as changing the primaryKey to matchId - not the greatest of fixes
	// 	return 'matchId';
	// }
	public function match()
	{
		return $this->belongsTo('Match','matchId','matchId');
	}

	public function events()
	{
		return $this->hasMany('TimelineEvent','timelineFrameId','id');
	}

	public function participantFrame()
	{
		return $this->hasMany('TimelineParticipantFrame','timelineFrameId','id');	
	}
}