<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('type');
	        $table->string('path', 100);
	        $table->string('title', 500);
	        $table->string('subtitle', 500)->nullable();
	        $table->text('content')->nullable();
	        $table->string('link', 500)->nullable();
	        $table->integer('rating')->nullable();
	        $table->integer('year')->nullable();
	        $table->boolean('spoilers')->default(0);
	        $table->dateTime('date_completed');
	        $table->string('creator', 500)->nullable();
	        $table->string('season', 100)->nullable();
	        $table->string('platform', 100)->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
