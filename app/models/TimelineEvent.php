<?php

class TimelineEvent extends \Eloquent {
	protected $table="timeline_frames_events";

	protected $primaryKey = 'id';

	public function frame()
	{
		return $this->belongsTo('TimelineFrame','timelineFrameId','id');
	}

	public function assistants()
	{
		return $this->hasMany('TimelineEventAssistant','eventTableId','id');
	}

	public function match()
	{
		return $this->frame->match;
	}

	public function participant()
	{
		return $this->frame->match->participants()->where('participantId','=',$this->participantId);
	}

}