<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateParticipantsStatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('participants_stats', function(Blueprint $table)
		{
			$table->integer('participantTableId')->unsigned()->primary();
			$table->integer('assists')->unsigned();
			$table->integer('champLevel')->unsigned();
			$table->integer('deaths')->unsigned();
			$table->integer('doubleKills')->unsigned();
			$table->tinyInteger('firstBloodAssist')->nullable();
			$table->tinyInteger('firstBloodKill')->nullable();
			$table->tinyInteger('firstInhibitorAssist')->nullable();
			$table->tinyInteger('firstInhibitorKill')->nullable();
			$table->tinyInteger('firstTowerAssist')->nullable();
			$table->tinyInteger('firstTowerKill')->nullable();
			$table->integer('goldEarned')->unsigned();
			$table->integer('goldSpent')->unsigned();
			$table->integer('inhibitorKills')->unsigned();
			$table->integer('item0')->unsigned();
			$table->integer('item1')->unsigned();
			$table->integer('item2')->unsigned();
			$table->integer('item3')->unsigned();
			$table->integer('item4')->unsigned();
			$table->integer('item5')->unsigned();
			$table->integer('item6')->unsigned();
			$table->integer('killingSprees')->unsigned();
			$table->integer('kills')->unsigned();
			$table->integer('largestCriticalStrike')->unsigned();
			$table->integer('largestKillingSpree')->unsigned();
			$table->integer('largestMultiKill')->unsigned();
			$table->integer('magicDamageDealt')->unsigned();
			$table->integer('magicDamageDealtToChampions')->unsigned();
			$table->integer('magicDamageTaken')->unsigned();
			$table->integer('minionsKilled')->unsigned();
			$table->integer('neutralMinionsKilled')->unsigned();
			$table->integer('neutralMinionsKilledEnemyJungle')->unsigned();
			$table->integer('neutralMinionsKilledTeamJungle')->unsigned();
			$table->integer('nodeCapture')->nullable()->unsigned();
			$table->integer('nodeCaptureAssist')->nullable()->unsigned();
			$table->integer('nodeNeutralize')->nullable()->unsigned();
			$table->integer('nodeNeutralizeAssist')->nullable()->unsigned();
			$table->integer('objectivePlayerScore')->nullable()->unsigned();
			$table->integer('pentaKills')->unsigned();
			$table->integer('physicalDamageDealt')->unsigned();
			$table->integer('physicalDamageDealtToChampions')->unsigned();
			$table->integer('physicalDamageTaken')->unsigned();
			$table->integer('quadraKills')->unsigned();
			$table->integer('sightWardsBoughtInGame')->unsigned();
			$table->integer('teamObjective')->nullable()->unsigned();
			$table->integer('totalDamageDealt')->unsigned();
			$table->integer('totalDamageDealtToChampions')->unsigned();
			$table->integer('totalDamageTaken')->unsigned();
			$table->integer('totalHeal')->unsigned();
			$table->integer('totalTimeCrowdControlDealt')->unsigned();
			$table->integer('totalUnitsHealed')->unsigned();
			$table->integer('towerKills')->unsigned();
			$table->integer('tripleKills')->unsigned();
			$table->integer('trueDamageDealt')->unsigned();
			$table->integer('trueDamageDealtToChampions')->unsigned();
			$table->integer('trueDamageTaken')->unsigned();
			$table->integer('unrealKills')->unsigned();
			$table->integer('visionWardsBoughtInGame')->unsigned();
			$table->integer('wardsKilled')->unsigned();
			$table->integer('wardsPlaced')->unsigned();
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
		Schema::drop('participants_stats');
	}

}
