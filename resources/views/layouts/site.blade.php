<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Styles -->
		<link href="{{ asset('css/site.css') }}" rel="stylesheet">
	</head>
	<body>

		<div class="almn-header">
		</div>

		<div class="almn-page">
			<div class="almn-sidebar-wrap">
				<div class="almn-sidebar">
					<h1><a href="/">{{ env('SITE_TITLE', 'Almanac') }}</a></h1>
					@if (env('SITE_SUBTITLE')) <h2>{{ env('SITE_SUBTITLE') }}</h2> @endif

					@if (env('SITE_DESCRIPTION')) <p>{{ env('SITE_DESCRIPTION') }}</p> @endif

					<div class="almn-sidebar--browse">
						<div class="almn-sidebar--browse__links">
							@if (env('TWITTER'))
								<div class="almn-sidebar--browse__links--icon">
									<a href="https://twitter.com/{{ env('TWITTER') }}">
										<i class="fab fa-twitter" data-fa-transform="grow-8"></i>
									</a>
								</div>
							@endif
							@if (env('INSTAGRAM'))
								<div class="almn-sidebar--browse__links--icon">
									<a href="https://instagram.com/{{ env('INSTAGRAM') }}">
										<i class="fab fa-instagram" data-fa-transform="grow-8"></i>
									</a>
								</div>
							@endif
							@if (env('FACEBOOK'))
								<div class="almn-sidebar--browse__links--icon">
									<a href="https://facebook.com/{{ env('FACEBOOK') }}">
										<i class="fab fa-facebook" data-fa-transform="grow-8"></i>
									</a>
								</div>
							@endif
							@if (env('WEBSITE'))
								<div class="almn-sidebar--browse__links--icon">
									<a href="{{ env('WEBSITE') }}">
										<i class="fas fa-globe" data-fa-transform="grow-8"></i>
									</a>
								</div>
							@endif
						</div>
						<ul class="almn-sidebar--browse__list">
							<li><a href="/category/movie">Movies</a></li>
							<li><a href="/category/tv">TV</a></li>
							<li><a href="/category/game">Games</a></li>
							<li><a href="/category/music">Music</a></li>
							<li><a href="/category/book">Books</a></li>
							<li><a href="/category/comic">Comics</a></li>
							<li><a href="/category/podcast">Podcasts</a></li>
							<li><a href="/category/video">Videos</a></li>
							<li><a href="/category/text">Text Posts</a></li>
							<li><a href="/tags">Tags</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="almn-posts-wrap">
				<div class="almn-posts">
					@yield('content')
				</div>
				<div class="almn-footer">
					Powered by <a href="https://github.com/rmlewisuk/almanac">Almanac</a>@if (env('WEBSITE')) | <a href="{{ env('WEBSITE') }}">{{ env('WEBSITE_TITLE', env('WEBSITE')) }}</a> @endif
				</div>
			</div>
		</div>

		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	</body>

</html>
