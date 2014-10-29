<?php

class ParticipantStat extends \Eloquent {
	protected $table = "participants_stats";

	public $timestamps = false;

	protected $fillable = array('assists','champLevel','deaths','doubleKills','firstBloodAssist','firstBloodKill','firstInhibitorAssist','firstInhibitorKill','firstTowerAssist','firstTowerKill','goldEarned','goldSpent','inhibitorKills','item0','item1','item2','item3','item4','item5','item6','killingSprees','kills','largestCriticalStrike','largestKillingSpree','largestMultiKill','magicDamageDealt','magicDamageDealtToChampions','magicDamageTaken','minionsKilled','neutralMinionsKilled','neutralMinionsKilledEnemyJungle','neutralMinionsKilledTeamJungle','nodeCapture','nodeCaptureAssist','nodeNeutralize','nodeNeutralizeAssist','objectivePlayerScore','pentaKills','physicalDamageDealt','physicalDamageDealtToChampions','physicalDamageTaken','quadraKills','sightWardsBoughtInGame','teamObjective','totalDamageDealt','totalDamageDealtToChampions','totalDamageTaken','totalHeal','totalTimeCrowdControlDealt','totalUnitsHealed','towerKills','tripleKills','trueDamageDealt','trueDamageDealtToChampions','trueDamageTaken','unrealKills','visionWardsBoughtInGame','wardsKilled','wardsPlaced','winner');

	protected $primaryKey = 'participantTableId';

	public function participant()
	{
		return $this->belongsTo('Participant','participantTableId','id');
	}
	
}