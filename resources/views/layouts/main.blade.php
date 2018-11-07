<!DOCTYPE html>
<html lang="ar">
	@include('partials.header')
	<body>
		<div class="container-fluid wrap">
			{{--<nav class="header row navbar navbar-default navbar-accent navbar-fixed-top"><div calss="container">@include('partials.navbar')</div></nav>--}}
			<nav class="header row navbar navbar-accent navbar-fixed-top"><div class="navbar-content"> @include('partials.navbar')</div></nav>
			<div class="content container">
				@include('flash::message')
				@yield('content')
			</div>
		</div>
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="/js/mainJS.js"></script>
	@stack('scripts.footer')
	</body>
</html>