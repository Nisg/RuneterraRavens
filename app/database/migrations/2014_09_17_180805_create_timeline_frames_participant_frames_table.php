<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimelineFramesParticipantFramesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timeline_frames_participant_frames', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('timelineFrameId')->unsigned()->index();
			$table->integer('participantId')->unsigned();
			$table->integer('positionX')->unsigned();
			$table->integer('positionY')->unsigned();
			$table->integer('currentGold')->unsigned();
			$table->integer('totalGold')->unsigned();
			$table->integer('level')->unsigned();
			$table->integer('xp')->unsigned();
			$table->integer('minionsKilled')->unsigned();
			$table->integer('jungleMinionsKilled')->unsigned();
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
		Schema::drop('timeline_frames_participant_frames');
	}

}
