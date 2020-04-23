<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>@if (isset($singlePost)) {{ $singlePost->title }} - @endif{{ env('SITE_TITLE', 'Almanac') }}</title>

		<!-- Styles -->
		<link href="{{ asset('css/site.css') }}" rel="stylesheet">

		<link rel="apple-touch-icon" type="image/png" sizes="114x114" href="{{ asset('apple-touch-icon.png') }}">

		@if (isset($singlePost))
			<meta name="twitter:card" content="summary">
			<meta name="twitter:site" content="@rknightuk">
			<meta name="twitter:title" content="{{ $singlePost->title }}">
			<meta name="twitter:description" content="{{ $singlePost->twitter_preview }}">
		@endif
	</head>
	<body>
		<div class="almn-page">
			<div class="almn-posts-wrap">
				<div class="almn-posts">
					@yield('content')
				</div>
				<div class="almn-footer">
					Powered by <a href="https://code.robblewis.me/almanac">Almanac</a>@if (env('WEBSITE')) | <a href="{{ env('WEBSITE') }}">{{ env('WEBSITE_TITLE', env('WEBSITE')) }}</a> @endif
				</div>
			</div>
		</div>

		<script defer src="https://use.fontawesome.com/releases/v5.4.1/js/all.js"></script>
		<script>
			(function() {
				var spoilers = document.getElementsByClassName("almn-post--content__spoiler");

				for (var i = 0; i < spoilers.length; i++) {
					var spoiler = spoilers[i]
					spoiler.addEventListener('click', function(e) {
						e.currentTarget.className += ' almn-post--content__spoiler--show'
					}, false);
				}
			})();
		</script>
	</body>

</html>
