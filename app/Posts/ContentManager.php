<?php
namespace App\Posts;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\GithubFlavoredMarkdownConverter;
use MediaEmbed\MediaEmbed;

class ContentManager {

    public function convertToHtml(Post $post)
    {
        if (is_null($post->content)) return null;

        $environment = new Environment([]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new AutolinkExtension());

        $converter = new GithubFlavoredMarkdownConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => true,
        ]);

        $content = $converter->convert($post->content);

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
