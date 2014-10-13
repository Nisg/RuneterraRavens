@extends('layouts.master-nosidebar')

@section('title')
Leona - Match - {{$match->matchId}}
@stop

@section('content')
	<h1 class="content-title text-center">Match - {{$match->matchId}}</h1>
	<h4 class="text-center">{{app('DataDragon')->getQueueType($match->queueType)}}</h4>

	<div class="row collapse" id="match-details">
		<div class="large-4 columns">
			Victory
		</div>
		<div class="large-4 columns">
			KDA
		</div>
		<div class="large-4 columns">
			DEFEAT
		</div>
	</div>
	<div class="row collapse" id="participant-info">
		<div class="large-6 columns">
			<ul class="grid-list">
				@foreach ($match->participants as $participant)
					@if ($participant->teamId==100)
						@include('match.partial.participant', array(
						'participant'=>$participant,
						'stats'=>$participant->stats,
					))
					@endif
				@endforeach
			</ul>
		</div>
		<div class="large-6 columns">
			<ul class="grid-list">
				@foreach ($match->participants as $participant)
					@if ($participant->teamId==200)
						@include('match.partial.participant', array(
						'participant'=>$participant,
						'stats'=>$participant->stats,
					))
					@endif
				@endforeach
			</ul>
		</div>
	</div>

@stop

@section('side-nav')
What do I put here?
@stop

@section('page_scripts')
	
@stop
