<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('matchId')->unsigned()->index();
			$table->integer('summonerId')->unsigned()->nullable()->index();
			$table->smallInteger('championId')->unsigned();
			$table->smallInteger('spell1Id')->unsigned();
			$table->smallInteger('spell2Id')->unsigned();
			$table->smallInteger('teamId')->unsigned();
			$table->string('role')->index();
			$table->string('lane')->index();
			$table->timestamps();
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
		Schema::drop('participants');
	}

}
