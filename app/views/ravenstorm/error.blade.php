@extends('layout.ravenstorm')

@section('title')
Ravenstorm Error
@stop

@section('content')
<div class="row">
	<div class="large-12 columns text-left">
		<h2>Something didn't go as planned</h2>
		<p>{{$error}}</p>
	</div>
	
</div>
@stop

@section('page_scripts')
	
@stop

@section('end_scripts')

@stop
