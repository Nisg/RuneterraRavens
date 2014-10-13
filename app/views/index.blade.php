@extends('layout.master')

@section('title')
Leona
@stop

@section('content')
	<h1 class="content-title">Summoner List</h1>
    Currently indexing <?php echo $summonercount;?> summoners and <?php echo $matchcount; ?> games

	<ul class="small-block-grid-3">
	<?php

	foreach ($users as $user) {
		echo "<li>".HTML::linkRoute('profile',$user->summonerName,$user->summonerId)."</li>";
	}

	?>
	</ul>
@stop
