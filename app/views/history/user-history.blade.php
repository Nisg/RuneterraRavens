@extends('layout.master')

@section('title')
Leona - {{$user->summonerName}} - Match History
@stop

@section('context-menu')
<li><button id="filters-button" class="tiny button">Filters</button></li>
<li><button class="tiny button">Send selected to graph</button></li>
<li><button class="tiny button">Send all to graph</button></li>

<div id="filters" class="panel callout radius">
	<h3>Filters:</h3>
	{{Form::open(array('route' => array('profile', $user->summonerId),'method'=>'get'))}}

	{{Form::label('champion','Champions:')}}
	{{Form::select('champion[]',app('DataDragon')->getAllChampions(),Input::get('champion'),array('multiple','class'=>'filter_box','data-placeholder'=>'Choose a champion...'))}}
	{{Form::label('map','Maps:')}}
	{{Form::select('map[]',app('DataDragon')->getMaps(),Input::get('map'),array('multiple','class'=>'filter_box','data-placeholder'=>'Choose a map...'))}}
	{{Form::label('queue','Queue Type:')}}
	{{Form::select('queue[]',app('DataDragon')->getQueues(),Input::get('queue'),array('multiple','class'=>'filter_box','data-placeholder'=>'Choose a queue type...'))}}
	{{Form::button('Go!', array('type'=>'submit','class'=>'button expand small'))}}
	
	{{Form::close()}}
</div>
@stop

@section('content')
<div class="row">
	@if (count($matches) > 0)
		<div class="large-6 columns">
	@else
		<div class="large-12 columns">
	@endif
		<div class="row">
			<div class="large-12 columns match-list">
			@include('history.partial.multiple-match')
			</div>
		</div>
		<div class="row text-center">
			{{ $matches->links() }}
		</div>
	</div>
	@if (count($matches) > 0)
	<div class="large-6 columns">
		<div class="panel" id="match-summary">
			
				@if($participant=$matches[0]->participants()->where('summonerId',$user->summonerId)->first())
				@endif
				@include('history.partial.match-summary', array('match'=>$matches[0],'participantId'=>$participant))
			
		</div>
	</div>
	@endif
</div>
@stop

@section('page_scripts')
	{{ HTML::script('js/match-history.js')}}
@stop
