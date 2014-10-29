@extends('layout.ravenstorm')

@section('title')
Ravenstorm Leaderboards
@stop

@section('content')
<div class="row">
	<div class="large-12 columns text-center">
		<h2>Leaderboards</h2>
	</div>
	<div class="large-12 columns text-left">
		<ul>
			@foreach($users as $user)
			<li>{{HTML::linkRoute('ravenstormUser',$user->summonerName,$user->summonerId)}} - {{round($user->ravenscore,2)}} RS</li>
			@endforeach
		</ul>
		{{ $users->links() }}
	</div>
</div>
@stop

@section('page_scripts')
	{{ HTML::script('js/match-history.js')}}
@stop
