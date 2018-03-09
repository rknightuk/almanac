<?php
namespace Almanac\Posts;

use Jonnybarnes\CommonmarkLinkify\LinkifyExtension;
use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use MediaEmbed\MediaEmbed;

class ContentManager {

	const SPOTIFY_REGEX = '#https?:\/\/open\.spotify\.com\/(track|album|user\/.+?\/playlist)\/([a-z0-9]{22})\/?#i';
	const SPOTIFY_EMBED_URL = 'https://embed.spotify.com/';

	public function convertToHtml(Post $post)
	{
		$env = Environment::createCommonMarkEnvironment();
		$env->addExtension(new LinkifyExtension());

		$converter = new Converter(new DocParser($env), new HtmlRenderer($env));

		$markdown = $converter->convertToHtml($post->content);
		$content = $this->wrapSpoilers($post->spoilers, $markdown);

		return $post->link ? $this->attemptEmbed($post->link, $content) : $content;
	}

	private function wrapSpoilers(bool $spoilers, string $content)
	{
		if ($spoilers) {
			$content = str_replace('[spoiler]', '', $content);
			$content = str_replace('[/spoiler]', '', $content);
			$content = '<div class="almn-post--content__spoiler">' . $content;
			$content =  $content . '</div>';
		} else {
			$content = str_replace('[spoiler]', '<span class="almn-post--content__spoiler">', $content);
			$content = str_replace('[/spoiler]', '</span>', $content);
		}

		return $content;
	}

	private function attemptEmbed(string $link, string $content)
	{
		if ($video = $this->getVideoEmbed($link)) {
			$content = $this->appendEmbed($content, $video);
		}

		if ($music = $this->getMusicEmbed($link)) {
			$content = $this->appendEmbed($content, $music);
		}

		return $content;
	}

	private function appendEmbed(string $content, string $embed)
	{
		return $embed . "\n" . $content;
	}

	public function getMusicEmbed(string $link)
	{
		if (!preg_match(self::SPOTIFY_REGEX, $link, $matches)) return null;
		if (empty($matches)) return null;

		list($link, $type, $id) = $matches;

		$type = str_replace( '/', ':', $type );

		$width = 600;
		$height = 300;

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

	private function getVideoEmbed(string $link)
	{
		$embed = (new MediaEmbed())->parseUrl($link);

		if (!$embed) return null;

		return $embed->setAttribute([
			'type' => null,
			'class' => 'iframe-class',
			'data-html5-parameter' => true,
			'width' => 600,
		])->getEmbedCode();
	}

}