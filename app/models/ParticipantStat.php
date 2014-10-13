<?php

class ParticipantStat extends \Eloquent {
	protected $table = "participants_stats";

	protected $primaryKey = 'participantTableId';

	public function participant()
	{
		return $this->belongsTo('Participant','participantTableId','id');
	}

}