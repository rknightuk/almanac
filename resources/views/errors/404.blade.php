@extends('layouts.site')

@section('content')
	<div class="almn-post almn-post__bad">
		<a class="almn-post--icon almn-post--icon__bad">
			<i class="fas fa-exclamation-circle"></i>
		</a>
		<div class="almn-post--titles">
			<div class="almn-post--titles--main">
				OH NO
			</div>
			<div class="almn-post--titles--sub">
				A terrible misfortune has befallen you.
			</div>
		</div>

		<div class="almn-post--content">
			<p>This page might have moved or been deleted.</p>

			<p><a href="/">Maybe the home page has what you're looking for?</a></p>
		</div>

		<footer class="almn-post--footer">
		</footer>
	</div>
@endsection
