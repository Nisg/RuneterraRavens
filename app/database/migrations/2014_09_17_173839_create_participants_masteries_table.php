<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticipantsMasteriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participants_masteries', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('participantTableId')->unsigned()->index();
			$table->smallInteger('masteryId')->unsigned();
			$table->smallInteger('rank')->unsigned();
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
		Schema::drop('participants_masteries');
	}

}
