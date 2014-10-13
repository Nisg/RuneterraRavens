<div class="row">
	<div class="large-8 columns text-left">
		<h4 id="match-summary-title">{{$participant->summonerName}} - Match #{{$participant->match->matchId}}</h4>
	</div>
	<div class="large-4 columns text-right">
		<a href="#" class="tiny button">View complete info</a>
	</div>
</div>
<div class="row">
	<div class="large-12 columns text-left">
		<table id="match-summary-table">
			<tr>
				<th>Kills</th>
				<td class="cell-stat">{{$participant->stats->kills or "0"}}</td>
				<td class="cell-stat text-right">{{round($participant->stats->totalDamageDealt/1000,1)}}k</td>
				<th>Damage Dealt</th>
			</tr>
			<tr>
				<th>Assists</th>
				<td class="cell-stat">{{$participant->stats->assists or "0"}}</td>
				<td class="cell-stat text-right">{{round($participant->stats->totalDamageDealtToChampions/1000,1)}}k</td>
				<th>Damage Dealt to Champions</th>
			</tr>
			<tr>
				<th>Deaths</th>
				<td class="cell-stat">{{$participant->stats->deaths or "0"}}</td>
				<td class="cell-stat text-right">{{round($participant->stats->totalDamageTaken/1000,1)}}k</td>
				<th>Damage Taken</th>
			</tr>
			<tr>
				<th>Gold Earned</th>
				<td class="cell-stat">{{round($participant->stats->goldEarned/1000,1)}}k</td>
				<td class="cell-stat text-right">{{round($participant->stats->totalHeal/1000,1)}}k</td>
				<th>Total Healing Done</th>
			</tr>
			<tr>
				<th>Total Minions Slain</th>
				<td class="cell-stat">{{$participant->stats->minionsKilled}}</td>
				<td class="cell-stat text-right">{{$participant->stats->neutralMinionsKilled}}</td>
				<th>Jungle Monsters Slain</th>
			</tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="large-12 columns" id="match-summary-tabrow">
		<dl class="tabs" id="match-summary-tabs" data-tab> 
			<dd class="active"><a href="#skill-order">Skill Order</a></dd>
			<dd><a href="#item-build">Item Build</a></dd>
			<dd><a href="#events">Events</a></dd>
		</dl>
		<div class="tabs-content" id="match-summary-content"> 
			<div class="content active" id="skill-order">
				<?php $skillLevelEvents = array_values(array_filter(iterator_to_array($participant->events),function ($event) {return ($event->eventType=="SKILL_LEVEL_UP");}));
					$champion = app('DataDragon')->getChampion($participant->championId);
				?>
				@if (count($skillLevelEvents))
				<table>
					<tr>
						<th> 
							{{HTML::image("/img/spell/".$champion['spells'][0]['image']['full'], $champion['spells'][0]['name'], array('class'=>'image-tooltip ability-image','data-tooltip-type'=>'spell','data-tooltip-id'=>$champion['spells'][0]['id'],'data-tooltip-champion'=>$champion['key']))}}							
							<span>{{$champion['spells'][0]['name']}}</span>
						</th>
						@for ($i=0; $i < count($skillLevelEvents); $i++) 
							<td>
								@if ($skillLevelEvents[$i]->skillSlot==1)
									<div class="level-skill">{{$i+1}}</div>
								@endif
							</td>
						@endfor
					</tr>
					<tr>
						<th>
							{{HTML::image("/img/spell/".$champion['spells'][1]['image']['full'], $champion['spells'][1]['name'], array('class'=>'image-tooltip ability-image','data-tooltip-type'=>'spell','data-tooltip-id'=>$champion['spells'][1]['id'],'data-tooltip-champion'=>$champion['key']))}}							
							<span>{{$champion['spells'][1]['name']}}</span>
						</th>
						@for ($i=0; $i < count($skillLevelEvents); $i++)
							<td>
								@if ($skillLevelEvents[$i]->skillSlot==2)
									<div class="level-skill">{{$i+1}}</div>
								@endif
							</td>
						@endfor
					</tr>
					<tr>
						<th>
							{{HTML::image("/img/spell/".$champion['spells'][2]['image']['full'], $champion['spells'][2]['name'], array('class'=>'image-tooltip ability-image','data-tooltip-type'=>'spell','data-tooltip-id'=>$champion['spells'][2]['id'],'data-tooltip-champion'=>$champion['key']))}}							
							<span>{{$champion['spells'][2]['name']}}</span>
						</th>
						@for ($i=0; $i < count($skillLevelEvents); $i++)
							<td>
								@if ($skillLevelEvents[$i]->skillSlot==3)
									<div class="level-skill">{{$i+1}}</div>
								@endif
							</td>
						@endfor
					</tr>
					<tr>
						<th>
							{{HTML::image("/img/spell/".$champion['spells'][3]['image']['full'], $champion['spells'][3]['name'], array('class'=>'image-tooltip ability-image','data-tooltip-type'=>'spell','data-tooltip-id'=>$champion['spells'][3]['id'],'data-tooltip-champion'=>$champion['key']))}}							
							<span>{{$champion['spells'][3]['name']}}</span>
						</th>
						@for ($i=0; $i < count($skillLevelEvents); $i++)
							<td>
								@if ($skillLevelEvents[$i]->skillSlot==4)
									<div class="level-skill">{{$i+1}}</div>
								@endif
							</td>
						@endfor
					</tr>
				</table>
				@else
					<p>No skill information was found</p>
				@endif
			</div>
			<div class="content" id="item-build">
				<?php
				$itemEvents = array_values(array_filter(iterator_to_array($participant->events),function ($event) {return ((($event->eventType=="ITEM_PURCHASED") || ($event->eventType=="ITEM_SOLD") || ($event->eventType=="ITEM_UNDO") || ($event->eventType=="ITEM_DESTROYED")) && ($event->itemId!=0));}));
				$itemEventsGrouped = array();

				foreach ( $itemEvents as $event ) {
    				$itemEventsGrouped[$event['timelineFrameId']][] = $event;
				}

				//This is a case of controller logic in views. Please do something! Save me!
				?>
				@foreach ($itemEventsGrouped as $eventGroup)
					<div class="build-step">
						<div class="build-step-arrow">
							{{HTML::image("/img/misc/build-connector.png")}}
						</div>
						<div class="build-step-wrapper clearfix">
							<div class="build-step-items">
							@foreach ($eventGroup as $event)
								<?php
								$item = $event['itemId'];
								?>
								@if (($event['eventType'] == "ITEM_DESTROYED") || ($event['eventType'] == "ITEM_SOLD") || ($event['eventType'] == "ITEM_UNDO" ))
								<div class="build-step-item item-sell">
								@else
								<div class="build-step-item">
								@endif
								{{HTML::image("/img/item/".app('DataDragon')->getItem($item)['image']['full'],$item,array('class'=>'image-tooltip','data-tooltip-type'=>'item','data-tooltip-id'=>$item))}}
								</div>
							@endforeach
							</div>
							<div class="build-step-time text-center">
							 {{gmdate("i:s", $eventGroup[0]['timestamp']/1000)}}
							</div>
						</div>
					</div>
				@endforeach	
			</div> 
			<div class="content" id="events">
				<?php 
				$playerEvents = array_values(array_filter(iterator_to_array($participant->events),function ($event) {return (($event->eventType=="CHAMPION_KILL") || ($event->eventType=="ELITE_MONSTER_KILL")); }));
				?>
				@foreach ($playerEvents as $event)
					<div class="event">
						<?php 
							//This is just a proof of concept, should NOT be left like this!
							$killer = $participant->match->participants[$event['killerId']-1];
							if ($event['eventType']=="CHAMPION_KILL")
								$victim = $participant->match->participants[$event['victimId']-1];
							elseif ($event['eventType']=="ELITE_MONSTER_KILL")
								$victim = array (
										'name' => $event['monsterType'],
										'image' => array (
												'full' => $event['monsterType'].".png"
											)
									);
						?>
						{{HTML::image(
							app('DataDragon')->getChampionImagePath($killer->championId),
							app('DataDragon')->getChampionName($killer->championId), 
							array(
								'class'				=> 'image-tooltip',
								'data-tooltip-type' => 'champion',
								'data-tooltip-id' 	=> $killer->championId
								)
						)}}
						{{HTML::image("/img/misc/scoreboardicon_score.png")}}
						@if ($event['eventType']=="ELITE_MONSTER_KILL")
						{{HTML::image("/img/neutral/".$victim['image']['full'],$victim['name'])}}
						@else
						{{HTML::image(
							app('DataDragon')->getChampionImagePath($victim->championId),
							app('DataDragon')->getChampionName($victim->championId), 
							array(
								'class'				=> 'image-tooltip',
								'data-tooltip-type'	=> 'champion',
								'data-tooltip-id'	=> $victim->championId
								)
						)}}
						@endif
						{{gmdate("i:s", $event['timestamp']/1000)}}
 					</div>
				@endforeach
				
			</div>
		</div>
	</div>
</div>