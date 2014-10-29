<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		//Participant tables
		Schema::table('participants', function(Blueprint $table) {
			$table->foreign('matchId')->references('matchId')->on('matches')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('participants_stats', function(Blueprint $table) {
			$table->foreign('participantTableId')->references('id')->on('participants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		//Participant tables
		Schema::table('participants', function(Blueprint $table) {
			$table->dropForeign('participants_matchId_foreign');
		});
		Schema::table('participants_stats', function(Blueprint $table) {
			$table->dropForeign('participants_stats_participantTableId_foreign');
		});

	}

}
