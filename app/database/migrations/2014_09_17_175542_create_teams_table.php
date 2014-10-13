<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teams', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('matchId')->unsigned()->index();
			$table->integer('teamId')->unsigned();
			$table->smallInteger('baronKills')->unsigned();
			$table->smallInteger('dragonKills')->unsigned();
			$table->tinyInteger('firstBaron');
			$table->tinyInteger('firstBlood');
			$table->tinyInteger('firstDragon');
			$table->tinyInteger('firstInhibitor');
			$table->tinyInteger('firstTower');
			$table->smallInteger('inhibitorKills')->unsigned();
			$table->smallInteger('towerKills')->unsigned();
			$table->smallInteger('vilemawKills')->unsigned();
			$table->tinyInteger('winner');
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
		Schema::drop('teams');
	}

}
