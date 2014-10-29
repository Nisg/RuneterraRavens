@extends('layout.ravenstorm')

@section('title')
Ravenstorm User list
@stop

@section('content')
<div class="row">
	<div class="large-12 columns text-center">
		<h2>User list</h2>
	</div>
	<div class="large-12 columns text-left">
		<ul>
			@foreach($users as $user)
			<li>{{HTML::linkRoute('ravenstormUser',$user->summonerName,$user->summonerId)}}</li>
			@endforeach
		</ul>
		{{ $users->links() }}
	</div>
</div>
@stop

@section('page_scripts')
	{{ HTML::script('js/match-history.js')}}
@stop
