@if ($matches->count())

@foreach ($matches as $match)

	@if($participant=$match->participants()->where('summonerId',$user->summonerId)->first())


	@include('history.partial.single-match', array(
		'participant'=>$participant,
		'stats'=>$participant->stats,
		'match'=>$match
		))

	@endif
	
@endforeach
@else
<div class="panel filter-list"> 
<div data-alert class="alert-box warning">No matches found with your specified filters. Try removing some of these filters</div>
<h3>Filters:</h3>
{{Form::open(array('route' => array('profile', $user->summonerId),'method'=>'get'))}}
{{Form::label('champion','Champions:')}}
{{Form::select('champion[]',app('DataDragon')->getAllChampions(),Input::get('champion'),array('multiple','class'=>'filter_box visible','data-placeholder'=>'Choose a champion...'))}}
{{Form::label('map','Maps:')}}
{{Form::select('map[]',app('DataDragon')->getMaps(),Input::get('map'),array('multiple','class'=>'filter_box visible','data-placeholder'=>'Choose a map...'))}}
{{Form::label('queue','Queue Type:')}}
{{Form::select('queue[]',app('DataDragon')->getQueues(),Input::get('queue'),array('multiple','class'=>'filter_box visible','data-placeholder'=>'Choose a queue type...'))}}
{{Form::button('Go!', array('type'=>'submit','class'=>'button expand small'))}}
{{Form::close()}}
</div>
@endif