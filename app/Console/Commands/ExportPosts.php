<?php

namespace App\Console\Commands;

use App\Attachment;
use App\ExternalSearch\MicroBlogClient;
use App\Posts\Post;
use App\Posts\PostRepository;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Console\Command;

class ExportPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export posts';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $types = [
            'movie',
            'tv',
            'game',
            'music',
            'book',
            'podcast',
            'video',
        ];

        foreach ($types as $type)
        {
            echo $type;
            echo "\n";
        }

        $typeInput = $this->ask('post type?');

        if (!\in_array($typeInput, $types))
        {
            echo 'Invalid type';
            echo "\n";
            return;
        }

        /** @var PostRepository $repo */
        $repo = app(PostRepository::class);

        $posts = $repo->allByType($typeInput);

        /** @var Post $post */
        foreach ($posts as $post)
        {
            $rating = '';
            foreach (range(1, $post->rating) as $r)
            {
                $rating .= '★';
            }

            $date = $post->date_completed->toIso8601String();
            $dateForPath = $post->date_completed->format('Y-m-d');
            $category = \mb_strtoupper(\in_array($post->type, ['podcast', 'movie', 'game', 'book']) ? $post->type . 's' : $post->type);
            $category = 'Movies';
            if (in_array($post->id, [272,55,59,60,61,62,63,393,397,399,566,572,579,563,587,638,648,673,738,947,1024,1025,987,754,753,1012,1189,1188,1186]))
            {
                $category = 'Documentary';
            }
            if (\in_array($post->id, [352,1,3,40,86,223,443,444,445]))
            {
                $category = 'Stand Up';
            }
            $title = $post->title;
            if ($post->subtitle)
            {
                $title .= " ($post->subtitle)";
            }
            if ($post->season)
            {
                $title .= ' season ' . $post->season;
            }
            if ($post->year)
            {
                $title .= " ($post->year)";
            }
            $attachments = '';
            if (count($post->getSortedAttachments()) > 0)
            {
                $multiple = count($post->getSortedAttachments()) > 1;
                $attachments = array_map(function($attachment) use ($multiple) {
                    $filename = 'https://rknightuk.s3.us-east-1.amazonaws.com/almanac/' . $attachment['filename'];
                    return $multiple ? "<img src='$filename'>" : "![]($filename)";
                }, collect($post->getSortedAttachments())->toArray());
                $attachments = implode("\n", $attachments);
                if ($multiple)
                {
                    $attachments = "<div class='photogrid'>\n$attachments\n</div>";
                }
            }
            $myfile = fopen( \resource_path("exports/$post->type/$dateForPath-$post->path.md"), "w") or die("Unable to create file!");
$txt = "---
date: $date
url: $post->permalink.html
categories: $category
---
$title - $rating

$post->content

$attachments
";
            fwrite($myfile, $txt);
            fclose($myfile);
        }
    }
}
