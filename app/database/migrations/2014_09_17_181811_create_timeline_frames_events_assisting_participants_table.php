<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimelineFramesEventsAssistingParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timeline_events_assisting_participants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('eventTableId')->unsigned()->index();
			$table->smallInteger('participantId')->unsigned();
			$table->engine = 'InnoDB';
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('timeline_frames_events_assisting_participants');
	}

}
