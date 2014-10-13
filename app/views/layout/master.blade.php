<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>@yield('title')</title>

	{{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans') }}
	{{ HTML::style('css/foundation.css') }}
	{{ HTML::style('css/leona.css') }}
 	{{ HTML::style('css/tooltipster.css')}}
 	{{ HTML::style('css/chosen.css') }}

 </head>
<body>
	<header>
		<div class="row">
			<div class="large-2 columns text-left" id="logo">
				<a href="{{route('index')}}" class="tiny button">Leona</a>
			</div>
			<div class="large-4 columns text-center" id="main-menu">
				<ul class="button-group">
				  <li><a href="#" class="tiny button">Match History</a></li>
				  <li><a href="#" class="tiny button">Runes &amp; Masteries</a></li>
				  <li><a href="#" class="tiny button">Graphs</a></li>
				</ul>
			</div>
			<div class="large-4 columns text-center" id="page-context-menu">
				<ul class="button-group">
				  @yield('context-menu')
				</ul>
			</div>
			<div class="large-2 columns text-right" id="top-right-button">
				<a href="#" class="tiny button">Help!</a>
			</div>
		</div>
	</header>
	<section>
		@yield('content')
	</section>
    
    <div class="loading-modal"></div>
	
	{{ HTML::script('js/vendor/modernizr.js') }}
	{{ HTML::script('js/vendor/jquery.js') }}
	{{ HTML::script('js/vendor/jquery.tooltipster.min.js') }}
	{{ HTML::script('js/vendor/chosen.jquery.min.js') }}
	{{ HTML::script('js/foundation.min.js') }}
	{{ HTML::script('js/app.js') }}
	<script>
		$(document).foundation();
		baseURL = "{{url('/')}}";
	</script>

	@yield('page_scripts')

	<script>
		@yield('end_scripts')
	</script>
</body>
</html>