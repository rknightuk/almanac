<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('tags')->insert([
			[
				'tag' => 'Tag One',
				'created_at' => \Carbon\Carbon::now(),
				'updated_at' => \Carbon\Carbon::now(),
			],
		    [
		    	'tag' => 'Tag Two',
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
		    ],
		    [
		    	'tag' => 'Tag Three',
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
		    ]
	    ]);

	    DB::table('post_tags')->insert([
		    [
			    'post_id' => 1,
			    'tag_id' => 1,
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
		    ],
		    [
			    'post_id' => 1,
			    'tag_id' => 2,
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
		    ],
		    [
			    'post_id' => 1,
			    'tag_id' => 3,
			    'created_at' => \Carbon\Carbon::now(),
			    'updated_at' => \Carbon\Carbon::now(),
		    ]
	    ]);
    }
}
