<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimelineFramesEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timeline_frames_events', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('timelineFrameId')->unsigned()->index();
			$table->smallInteger('eventId')->unsigned();
			$table->string('buildingType');
			$table->smallInteger('creatorId')->unsigned();
			$table->string('eventType');
			$table->smallInteger('itemAfter')->unsigned();
			$table->smallInteger('itemBefore')->unsigned();
			$table->smallInteger('itemId')->unsigned();
			$table->smallInteger('killerId')->unsigned();
			$table->string('laneType');
			$table->string('levelUpType');
			$table->string('monsterType');
			$table->smallInteger('participantId')->unsigned();
			$table->smallInteger('positionX')->unsigned();
			$table->smallInteger('positionY')->unsigned();
			$table->smallInteger('skillSlot')->unsigned();
			$table->smallInteger('teamId')->unsigned();
			$table->bigInteger('timestamp')->unsigned();
			$table->string('towerType');
			$table->smallInteger('victimId')->unsigned();
			$table->string('wardType');
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
		Schema::drop('timeline_frames_events');
	}

}
