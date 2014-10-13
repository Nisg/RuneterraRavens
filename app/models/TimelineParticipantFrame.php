<?php

class TimelineParticipantFrame extends \Eloquent {
	protected $table="timeline_frames_participant_frames";

	protected $primaryKey = 'id';

	public function frame()
	{
		return $this->belongsTo('TimelineFrame','timelineFrameId','id');
	}


}