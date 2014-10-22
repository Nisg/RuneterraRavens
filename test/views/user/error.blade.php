@extends('layout.newmaster')

@section('title')
ERROR
@stop

@section('head')
{{ HTML::style('css/loading_modal.css') }}
{{ HTML::script('js/spin.js') }}
{{ HTML::script('js/loading_modal.js') }}
{{ HTML::script('js/update.js') }}
@stop

@section('content')
WE DO NOT TRACK ANY USER WITH ID {{$summonerId}} !!
<div id="modal"></div>
<div id="info"></div>
@stop
