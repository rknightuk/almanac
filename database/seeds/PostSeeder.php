<?php

use Almanac\Attachment;
use Almanac\Posts\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
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
        });
    }
}
