<?php

use Almanac\Attachment;
use Almanac\Posts\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    const TAGS = [
        'SHRT',
        'Longer Tag',
        'Another',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(Post::class, 100)->create()->each(function(Post $post) {
    	    if (rand(0, 3) == 1) {
                $post->attachments()->createMany(factory(Attachment::class, rand(1, 5))->make()->toArray());
            }

    	    if (rand(0, 2) === 1) {
    	        $post->attachTags(self::TAGS);
            }
        });
    }
}
