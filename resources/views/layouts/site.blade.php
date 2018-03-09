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
					<h1>{{ env('SITE_TITLE', 'Almanac') }}</h1>
					@if (env('SITE_SUBTITLE')) <h2>{{ env('SITE_SUBTITLE') }}</h2> @endif

					<div class="almn-sidebar--browse">
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
					Powered by <a href="https://github.com/rmlewisuk/almanac">Almanac</a>@if (env('FOOTER_TITLE')) | <a href="{{ env('FOOTER_LINK') }}">{{ env('FOOTER_TITLE') }}</a> @endif
				</div>
			</div>
		</div>

		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	</body>

</html>
