<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgradePostsTableAddImagesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->text('images')->after('slug')->nullable();
            $table->string('cover_image')->after('slug')->nullable();
            $table->dropColumn('image');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('images');
            $table->dropColumn('cover_image');
            $table->string('image')->after('slug')->nullable();
        });
    }
}
