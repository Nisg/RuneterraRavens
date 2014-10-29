@extends('layout.ravenstorm')

@section('title')
Ravenstorm {{$summonerName}}
@stop

@section('content')
<div class="row">
	<div class="large-12 columns text-center">
		@if (isset($ravenscore))
		<h2>{{$summonerName}} - {{$ravenscore}} RS</h2>
		@else
		<h2>{{$summonerName}}
		@endif
	</div>
	<div class="large-8 columns text-left" id="graph">
		<h3>Graphs</h3>
		<div>
			<canvas id="RavenstormChart" height="435px"></canvas>
		</div>
	</div>
	<div class="large-4 columns text-left" id="recent-matches">
		<h3>Recent Matches</h3>
		
		<table id="recent-matches-table">
			<thead>
				<tr>
					<td></td>
					<td data-tooltip aria-haspopup="true" class="has-tip" title="Kills">K</td>
					<td data-tooltip aria-haspopup="true" class="has-tip" title="Deaths">D</td>
					<td data-tooltip aria-haspopup="true" class="has-tip" title="Assists">A</td>
					<td data-tooltip aria-haspopup="true" class="has-tip" title="RavenstormScore. This is calculated using your KDA,CS and other factors. For more information see the FAQ">RS</td>
				</tr>
			</thead>
			<tbody>
				@if (isset($stats))
				@foreach($stats as $stat)
				<tr>
					<td
					@if ($stat->winner)
						class="win">
					@else
						class="loss">
					@endif
					{{HTML::image("/img/champion/".app('DataDragon')->getChampion($stat->participant->championId)['image']['full'], app('DataDragon')->getChampion($stat->participant->championId)['name'])}}
					</td>
					<td>
						{{$stat->kills}}
					</td>
					<td>
						{{$stat->deaths}}
					</td>
					<td>
						{{$stat->assists}}
					</td>
					<td>
						{{$stat->ravenscore}}
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="4">Not enough data was found</td>
				</tr>
				@endif
			</tbody>
		</table>
	</div>
	<div class="large-12 columns text-left">
	<h3>Averages</h3>
	<table id="averages-table">
		<thead>
			<tr>
				<td>Stat</td>
				<td>Average - all time</td>
				<td>Average - recent matches</td>
				<td>Difference</td>
			</tr>
		</thead>
		<tbody>
			@if(isset($averages))
			@foreach ($fields as $field)
			<tr>
				<td>{{Lang::get('user.'.$field)}}</td>
				<td>{{$averages['total'][$field]}}</td>
				<td>{{$averages['recent'][$field]}}</td>
				<td>{{round($averages['total'][$field]-$averages['recent'][$field],2)}}</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="4">Not enough data was found</td>
			</tr>
			@endif
		</tbody>
	</table>
	</div>
</div>
@stop

@section('page_scripts')

{{HTML::script('/js/getInfo.js')}}
	
@stop

@section('end_scripts')

<script>
// This is where we output our data and javascript
// This can be moved to another blade file if we will have multiple charts
    
var options = {
	responsive: true,
	maintainAspectRatio: false,
	//For a complete list of options and their defaults see the ChartJS Docs
	multiTooltipTemplate: "<%= datasetLabel %>: <%= value %>",
	pointHitDetectionRadius: 5,
	animationSteps: 20,
};
// Get context with jQuery - using jQuery's .get() method.
var ctx = $("#RavenstormChart").get(0).getContext("2d");

var chartData = {
	labels: Ravenstorm.labels, //These are the labels on the X axis - we can either have the dates of the games, or the games themselves (matchID or champion + matchId shown in case dates are too clunky)
	datasets: Ravenstorm.datasets
};
// This will get the first returned node in the jQuery collection.
var RavenstormChart = new Chart(ctx).Line(chartData, options);
</script>
@stop
