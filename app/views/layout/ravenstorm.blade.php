<!doctype html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<title>@yield('title')</title>

	{{ HTML::style('css/foundation.css') }}
	{{ HTML::style('css/ravenstorm.css') }}
 	
 </head>
<body>
	<nav class="top-bar" data-topbar role="navigation"> 
		<ul class="title-area"> 
			<li class="name">
				<h1>{{HTML::linkRoute('ravenstormHome',"Ravenstorm")}}</a></h1> 
			</li> 
			<li class="toggle-topbar menu-icon">
				<a href="#"><span>Menu</span></a></li>
		</ul>
		<section class="top-bar-section"> 
			<ul class="left">
				<li class="has-form">
					{{Form::open(array('route' => array('ravenstormSearch'),'method'=>'post'))}}
						<div class="row collapse">
						<div class="large-8 medium-8 small-9 columns">
							{{Form::text('summonerName',null,array('placeholder'=>'User name'))}}
						</div>
						<div class="large-4 medium-4 small-3 columns">
							{{Form::button('Search', array('type'=>'submit','class'=>'button small expand'))}}
						</div>
					</div>
					{{Form::close()}}
				</li>
			</ul>
			<ul class="right"> 
				<li class="">
					{{HTML::linkRoute('ravenstormLeaderboards',"Leaderboards")}}
				</li>
				<li class="">
					{{HTML::linkRoute('ravenstormUserlist',"User List")}}
				</li>
				<li class="">
					{{HTML::linkRoute('ravenstormFaq',"F.A.Q.")}}
				</li>
			</ul>
		</section>
	</nav>
	<section>
		@yield('content')
	</section>
    
    <div class="loading-modal"></div>
	
	{{ HTML::script('js/vendor/modernizr.js') }}
	{{ HTML::script('js/vendor/jquery.js') }}
	{{ HTML::script('js/Chart.min.js')}}
	{{ HTML::script('js/foundation.min.js') }}
	<script>
		$(document).foundation();
		baseURL = "{{url('/')}}";
	</script>

	@yield('page_scripts')
	
	@include('ravenstorm.jsdata')

	@yield('end_scripts')
</body>
</html>