<div class="panel match-panel">
	<div class="row">
		<div class="large-12 columns match-top-info text-center">
			<span class="map-type">{{app('DataDragon')->getMap($match->mapId)}}</span>
			<span class="queue-type">{{app('DataDragon')->getQueueType($match->queueType)}}</span>
			<span class="match-duration">{{gmdate("i:s", $match->matchDuration)}}</span>
			<span class="match-date">{{date("d-m-Y", $match->matchCreation/1000)}}</span>
		</div>
	</div>
	<div class="row">
		<div class="columns champion-image">
			{{HTML::image("/img/champion/".app('DataDragon')->getChampion($participant->championId)['image']['full'], app('DataDragon')->getChampion($participant->championId)['name'], array('class'=>'image-tooltip','data-tooltip-type'=>'champion','data-tooltip-id'=>$participant->championId))}}
			<span class="champion-image-level">{{$stats->champLevel}}</span>
		</div>
		<div class="columns summoner-spells text-center">
			<div class="summoner-spell">
				{{HTML::image("/img/spell/".app('DataDragon')->getSummonerSpell($participant->spell1Id)['image']['full'], app('DataDragon')->getSummonerSpell($participant->spell1Id)['name'],array("class"=>"summoner-spell image-tooltip",'data-tooltip-type'=>'summoner-spell','data-tooltip-id'=>$participant->spell1Id))}}
			</div>
			<div class="summoner-spell">
				{{HTML::image("/img/spell/".app('DataDragon')->getSummonerSpell($participant->spell2Id)['image']['full'], app('DataDragon')->getSummonerSpell($participant->spell2Id)['name'],array("class"=>"summoner-spell image-tooltip",'data-tooltip-type'=>'summoner-spell','data-tooltip-id'=>$participant->spell2Id))}}
			</div>
		</div>
		<div class="columns kda text-center">
			<div>
			<span class="kills">{{$stats->kills}}</span>/<span class="deaths">{{$stats->deaths}}</span>/<span class="assists">{{$stats->assists}}</span></div>
			<div>
				@if ($stats->deaths==0)
				<span class="label success">Perfect game</span>
				@elseif ($stats->pentaKills>0)
				<span class="label success">Penta kill</span>
				@elseif($stats->quadraKills>0)
				<span class="label success">Quadra kill</span>
				@elseif($stats->tripleKills>0)
				<span class="label success">Triple kill</span>
				@elseif($stats->doubleKills>0)
				<span class="label success">Double kill</span>
				@endif
			</div>
		</div>
		<div class="columns inventory">
			@for($i=0; $i<6; $i++)
				@if (($item=$stats->getAttribute("item".$i))>0)
					<div class="item">
						{{HTML::image("/img/item/".app('DataDragon')->getItem($item)['image']['full'],$item,array('class'=>'image-tooltip','data-tooltip-type'=>'item','data-tooltip-id'=>$item))}}
					</div>
				@else
					<div class="no-item"></div>
				@endif
			@endfor
		</div>
		<div class="columns trinket">
			@if (($item=$stats->getAttribute("item".$i))>0)
				<div class="item">
					{{HTML::image("/img/item/".app('DataDragon')->getItem($item)['image']['full'],$item,array('class'=>'image-tooltip','data-tooltip-type'=>'item','data-tooltip-id'=>$item))}}
				</div>
			@else
				<div class="no-item"></div>
			@endif
		</div>
		<div class="columns gold-cs text-center">
			<div class="gold">{{HTML::image("/img/misc/scoreboardicon_gold.png")}}{{round($stats->goldEarned/1000,1)}}k</div>
			<div class="cs">{{HTML::image("/img/misc/scoreboardicon_minion.png")}}{{$stats->minionsKilled}}</div>
		</div>
		<div class="columns wards text-center">
			<div class="ward">
				{{$stats->sightWardsBoughtInGame}} {{HTML::image("/img/item/2044.png", "Sight Ward",array("class"=>"image-tooltip",'data-tooltip-type'=>'item','data-tooltip-id'=>2044))}}
			</div>
			<div class="ward">
				{{$stats->visionWardsBoughtInGame}} {{HTML::image("/img/item/2043.png", "Vision Ward",array("class"=>"image-tooltip",'data-tooltip-type'=>'item','data-tooltip-id'=>2043))}}
			</div>
		</div>
		<div class="columns match-page">
			<button class="summary-button tiny button expand" data-participant-id="{{$participant->id}}">Summary</button>
			<a href="#" class="tiny button expand">Full Info</a>
		</div>
	</div>
	@if ($stats->winner === 1)
    <div class="result result-win"></div>
	@else
    <div class="result result-loss"></div>
    @endif
</div>