@extends('layout.newmaster')

@section('title')
{{$user->summonerName}}
@stop

@section('head')
{{ HTML::style('css/loading_modal.css') }}
{{ HTML::script('js/spin.js') }}
{{ HTML::script('js/loading_modal.js') }}
{{ HTML::script('js/update.js') }}
@stop

@section('content')
Click to update data
<div id="modal"></div>
<div id="info"></div>
@stop
