<?php
namespace Almanac\Posts;

use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\HtmlRenderer;
use MediaEmbed\MediaEmbed;

class ContentManager {

	public function convertToHtml(Post $post)
	{
        if (is_null($post->content)) return null;

		$env = Environment::createCommonMarkEnvironment();
		$env->addExtension(new AutolinkExtension());

		$converter = new Converter(new DocParser($env), new HtmlRenderer($env));

		$content = $converter->convertToHtml($post->content);

		return $post->link ? $this->attemptEmbed($post->link, $content) : $content;
	}

	private function attemptEmbed(string $link, string $content)
	{
		if ($video = $this->getVideoEmbed($link)) {
			$content = $this->appendEmbed($content, $video);
		}

		return $content;
	}

	private function appendEmbed(string $content, string $embed)
	{
		return $embed . "\n" . $content;
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
			'height' => 340,
		])->getEmbedCode();
	}

}
