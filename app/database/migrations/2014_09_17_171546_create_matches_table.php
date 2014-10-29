<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMatchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('matches', function(Blueprint $table)
		{
			$table->bigInteger('matchId')->unsigned();
			$table->bigInteger('matchCreation')->unsigned();
			$table->bigInteger('matchDuration')->unsigned();
			$table->smallInteger('mapId')->unsigned();
			$table->string('matchMode');
			$table->string('matchType');
			$table->string('matchVersion');
			$table->string('queueType');
			$table->string('region', 4);
			$table->string('season');
			$table->integer('frameInterval')->unsigned()->nullable();
			$table->timestamps();
			$table->primary(array('matchId', 'region'));
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
		Schema::drop('matches');
	}

}
