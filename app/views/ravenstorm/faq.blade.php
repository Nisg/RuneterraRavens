@extends('layout.ravenstorm')

@section('title')
Ravenstorm FAQ
@stop

@section('content')
<div class="row">
	<div class="large-12 columns text-left">
		<h2>F.A.Q.</h2>
		<dl> 
			<dt>What is this?</dt> 
			<dd>This little application was made as an attempt to create something unique for the community Runeterra Ravens. This uses Riot API to gather data and provide the user with a few graphs as well as a nice little feature called RavenScore - our own take on Fantasy LCS Points.</dd> 
			<dt>How is RavenScore calculated?</dt>
			<dd>The formula is very closely related to Riot's Fantasy LCS Points with a few additions to incentivize people to take objectives in the game! The negative cap of this score is 0
			<ul>
				<li>Kill: 4 points</li>
				<li>Assist: 3 points</li>
				<li>Death: -2 points</li>
				<li>1 CS: 0.03 points</li>
				<li>First blood: 4 points</li>
				<li>Quadra Kill: 10 points</li>
				<li>Penta Kill: 20 points</li>
				<li>More than 10 assists: 4 points</li>
				<li>Win: 5 points</li>
			</ul>
			</dd>
			<dt>Tools used</dt>
			<dd>Laravel, ChartJs and cURL</dd>
			<dt>Who made this?</dt>
			<dd>This was made by Stelar7 and Hitandyrun with generous help from the Runeterra Ravens community</dd>
		</dl>
	</div>
	
</div>
@stop

@section('page_scripts')
	
@stop

@section('end_scripts')

@stop
