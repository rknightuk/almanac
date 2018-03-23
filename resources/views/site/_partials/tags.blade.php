<ul>
	@foreach ($tags as $tag)
		<li><a href="/?tags[]={{ $tag }}">{{ $tag }}</a></li>
	@endforeach
</ul>