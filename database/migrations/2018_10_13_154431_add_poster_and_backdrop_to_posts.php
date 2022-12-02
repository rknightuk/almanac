<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPosterAndBackdropToPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('posts', function (Blueprint $table) {
		    $table->string('poster', 1000)->nullable()->after('published');
		    $table->string('backdrop', 1000)->nullable()->after('poster');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('posts', function (Blueprint $table) {
		    $table->dropColumn('poster');
		    $table->dropColumn('backdrop');
	    });
    }
}
