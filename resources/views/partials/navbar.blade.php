<div class="navbar-header">
	<!-- Collapsed Hamburger -->
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
		<span class="sr-only">Toggle Navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>

	<!-- Branding Image -->
	<a class="navbar-brand" href="{{ url('/') }}">
		<img class="navbar-brand-logo" src="{{asset("png/logo.png")}}" />
	</a>
</div>

<div class="collapse navbar-collapse" id="app-navbar-collapse">
	<!-- Left Side Of Navbar -->
	<ul class="nav navbar-nav">
		{{--&nbsp;<div class="input-group">--}}
			{{--<input type="text" class="form-control" placeholder="Username" aria-describedby="sizing-addon2">--}}
			{{--<span class="input-group-addon" id="sizing-addon2">in Jeddah</span>--}}
		{{--</div>--}}
	</ul>

	<!-- Right Side Of Navbar -->
	<ul class="nav navbar-nav navbar-left">
		<!-- Authentication Links -->
		@guest
			<li><a href="{{ route('login') }}">{{trans('auth.login')}}</a></li>
			<li><a href="{{ route('register') }}">{{trans('auth.register')}}</a></li>
			@else
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
					{{ Auth::user()->name }} <span class="caret"></span>
				</a>

				<ul class="dropdown-menu" role="menu">
					<li><a href="{{route('createPost')}}">{{trans('word.add_post')}}</a></li>
					<li><a href="{{route('userPreferences')}}">{{trans('word.preferances')}}</a></li>
					<li>
						<a href="{{ route('logout') }}"
						   onclick="event.preventDefault();
									 document.getElementById('logout-form').submit();">{{trans('auth.logout')}}</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</li>
				</ul>
			</li>
			<li><a href="{{route('userInMessages') }}">{{trans('word.my_messages')}}</a></li>
		@endguest
	</ul>
</div>