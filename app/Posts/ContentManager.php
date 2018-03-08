<?php
namespace Almanac\Posts;

class ContentManager {

	const SPOTIFY_REGEX = '#https?:\/\/open\.spotify\.com\/(track|album|user\/.+?\/playlist)\/([a-z0-9]{22})\/?#i';
	const SPOTIFY_EMBED_URL = 'https://embed.spotify.com/';

	public function getMusicEmbed(string $link)
	{
		if (!preg_match(self::SPOTIFY_REGEX, $link, $matches)) return null;
		if (empty($matches)) return null;

		list($link, $type, $id) = $matches;

		$type = str_replace( '/', ':', $type );

		$width = 600;
		$height = 400;

		$embed_src = sprintf(
			'%s?uri=spotify:%s:%s',
			self::SPOTIFY_EMBED_URL,
			$type,
			$id
		);

		$embed_src .= '&theme=white';

		return sprintf(
			'<iframe src="%s" width="%d" height="%d" frameborder="0" allowTransparency="true"></iframe>',
			$embed_src,
			(int) $width,
			(int) $height
		);
	}

}