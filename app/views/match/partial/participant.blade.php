<li class="participant">
	<div>
		<div>
			<div class="champion-image">
				{{HTML::image("/img/champion/".app('DataDragon')->getChampion($participant->championId)['image']['full'], app('DataDragon')->getChampion($participant->championId)['name'], array('class'=>'image-tooltip','data-tooltip-type'=>'champion','data-tooltip-id'=>$participant->championId))}}
				<span class="champion-image-level">{{$stats->champLevel}}</span>
			</div>
			<div class="spells">
				{{HTML::image("/img/spell/".app('DataDragon')->getSummonerSpell($participant->spell1Id)['image']['full'], app('DataDragon')->getSummonerSpell($participant->spell1Id)['name'],array("class"=>"summoner-spell image-tooltip",'data-tooltip-type'=>'summoner-spell','data-tooltip-id'=>$participant->spell1Id))}}
				{{HTML::image("/img/spell/".app('DataDragon')->getSummonerSpell($participant->spell2Id)['image']['full'], app('DataDragon')->getSummonerSpell($participant->spell2Id)['name'],array("class"=>"summoner-spell image-tooltip",'data-tooltip-type'=>'summoner-spell','data-tooltip-id'=>$participant->spell2Id))}}
			</div>
			<div class="champion-name">
				@if ($participant->summonerName)
				{{$participant->summonerName}}
				@else
				{{app('DataDragon')->getChampion($participant->championId)['name']}}
				@endif
			</div>
			<div class="inventory">
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
			<div class="trinket-slot">
				@if ($item=$stats->item6)
					<div class="item">
						{{HTML::image("/img/item/".app('DataDragon')->getItem($item)['image']['full'],$item,array('class'=>'image-tooltip','data-tooltip-type'=>'item','data-tooltip-id'=>$item))}}
					</div>
				@else
					<div class="no-item"></div>
				@endif
			</div>
			<div>
			</div>
		</div>
	</div>
</li>