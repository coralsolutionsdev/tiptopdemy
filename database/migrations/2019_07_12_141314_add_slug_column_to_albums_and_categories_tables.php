<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugColumnToAlbumsAndCategoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gallery_albums', function (Blueprint $table) {
            $table->string('slug')->after('title');
        });
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('slug')->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gallery_albums', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
