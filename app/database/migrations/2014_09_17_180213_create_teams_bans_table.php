<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeamsBansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('teams_bans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('teamTableId')->unsigned()->index();
			$table->smallInteger('championId')->unsigned();
			$table->smallInteger('pickTurn')->unsigned();
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
		Schema::drop('teams_bans');
	}

}
