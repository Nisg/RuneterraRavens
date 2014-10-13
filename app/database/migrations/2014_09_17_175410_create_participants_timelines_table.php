<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticipantsTimelinesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participants_timelines', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('participantTableId')->unsigned()->index();
			$table->string('timelineDataType');	
			$table->string('timelineDataInterval');
			$table->float('timelineData');
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
		Schema::drop('participants_timelines');
	}

}
