<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimelineFramesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('timeline_frames', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('matchId')->unsigned()->index();
			$table->smallInteger('frameId')->unsigned();
			$table->Integer('timestamp')->unsigned();
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
		Schema::drop('timeline_frames');
	}

}
