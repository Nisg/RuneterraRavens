@extends('layout.ravenstorm')

@section('title')
Ravenstorm
@stop

@section('content')
<div class="row">
	<div class="large-12 columns text-center">
		<h1>Welcome to Ravenstorm</h1>
		{{Form::open(array('route' => array('ravenstormSearch'),'method'=>'post'))}}

		{{Form::text('summonerName',null,array('placeholder'=>'Type in a user name','id'=>'search-box'))}}

		{{Form::button('Search', array('type'=>'submit','class'=>'button small'))}}
		
		{{Form::close()}}
	</div>
</div>
@stop

@section('page_scripts')
	
@stop

@section('end_scripts')

@stop
