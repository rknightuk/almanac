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
			<div class="almn-posts">
				@yield('content')
			</div>

			<div class="almn-footer">
				Powered by <a href="https://github.com/rmlewisuk/almanac">Almanac</a>@if (env('FOOTER_TITLE')) | <a href="{{ env('FOOTER_LINK') }}">{{ env('FOOTER_TITLE') }}</a> @endif
			</div>
		</div>

		<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	</body>

</html>
