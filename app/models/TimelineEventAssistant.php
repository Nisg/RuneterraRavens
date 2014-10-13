<?php

class TimelineEventAssistant extends \Eloquent {
	protected $table="timeline_events_assisting_participants";

	protected $primaryKey = 'id';

	public function event() 
	{
		return $this->belongsTo('TimelineEvent','eventTableId','id');
	}
}