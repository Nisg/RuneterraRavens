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
		Schema::table('participants_masteries', function(Blueprint $table) {
			$table->foreign('participantTableId')->references('id')->on('participants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('participants_runes', function(Blueprint $table) {
			$table->foreign('participantTableId')->references('id')->on('participants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('participants_stats', function(Blueprint $table) {
			$table->foreign('participantTableId')->references('id')->on('participants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('participants_timelines', function(Blueprint $table) {
			$table->foreign('participantTableId')->references('id')->on('participants')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		//Team tables
		Schema::table('teams', function(Blueprint $table) {
			$table->foreign('matchId')->references('matchId')->on('matches')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('teams_bans', function(Blueprint $table) {
			$table->foreign('teamTableId')->references('id')->on('teams')
						->onDelete('cascade')
						->onUpdate('cascade');
		});

		//Timeline tables
		Schema::table('timeline_frames', function(Blueprint $table) {
			$table->foreign('matchId')->references('matchId')->on('matches')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('timeline_frames_participant_frames', function(Blueprint $table) {
			$table->foreign('timelineFrameId')->references('id')->on('timeline_frames')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('timeline_frames_events', function(Blueprint $table) {
			$table->foreign('timelineFrameId')->references('id')->on('timeline_frames')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('timeline_events_assisting_participants', function(Blueprint $table) {
			$table->foreign('eventTableId')->references('id')->on('timeline_frames_events')
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
		Schema::table('participants_mastery', function(Blueprint $table) {
			$table->dropForeign('participants_masteries_participantTableId_foreign');
		});
		Schema::table('participants_runes', function(Blueprint $table) {
			$table->dropForeign('participants_runes_participantTableId_foreign');
		});
		Schema::table('participants_stats', function(Blueprint $table) {
			$table->dropForeign('participants_stats_participantTableId_foreign');
		});
		Schema::table('participants_timelines', function(Blueprint $table) {
			$table->dropForeign('participants_timelines_participantTableId_foreign');
		});

		//Team tables
		Schema::table('teams', function(Blueprint $table) {
			$table->dropForeign('team_matchId_foreign');
		});
		Schema::table('teams_bans', function(Blueprint $table) {
			$table->dropForeign('teams_bans_teamTableId_foreign');
		});

		//Timeline tables
		Schema::table('timeline_frames', function(Blueprint $table) {
			$table->dropForeign('timeline_frames_matchId_foreign');
		});
		Schema::table('timeline_frames_participant_frames', function(Blueprint $table) {
			$table->dropForeign('timeline_frames_participant_frames_timelineFrameId_foreign');
		});
		Schema::table('timeline_frames_events', function(Blueprint $table) {
			$table->dropForeign('timeline_frames_events_timelineFrameId_foreign');
		});
		Schema::table('timeline_frames_events_assisting_participants', function(Blueprint $table) {
			$table->dropForeign('timeline_events_assisting_participants_eventTableId_foreign');
		});
	}

}
