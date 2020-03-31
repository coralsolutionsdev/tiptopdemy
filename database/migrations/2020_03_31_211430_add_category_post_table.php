<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_blog_post', function (Blueprint $table) {
            $table->unsignedInteger('category_id')->index()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->unsignedInteger('blog_post_id')->index()->nullable();
            $table->foreign('blog_post_id')->references('id')->on('blog_posts')->onDelete('set null');
            $table->primary(['category_id', 'blog_post_id'], 'category_blog_post_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_blog_post');
    }
}
