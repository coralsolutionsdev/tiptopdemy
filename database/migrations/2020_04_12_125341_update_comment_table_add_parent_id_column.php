<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCommentTableAddParentIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_comments', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->index()->nullable()->default(0)->after('user_id');
            $table->foreign('parent_id')->references('id')->on('blog_comments')->onDelete('set null');
            $table->tinyInteger('status')->after('content');
            $table->dropColumn('parent');
            $table->dropColumn('likes');
            $table->dropColumn('dislikes');
        });
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->tinyInteger('allow_comments_status')->after('status')->nullable();
            $table->tinyInteger('default_comment_status')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_comments', function (Blueprint $table) {
            $table->dropForeign('blog_comments_parent_id_foreign');
            $table->dropColumn('parent_id');
            $table->dropColumn('status');
            $table->integer('parent')->after('user_id')->nullable();
            $table->integer('likes')->after('user_id')->nullable();
            $table->integer('dislikes')->after('user_id')->nullable();
        });
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('allow_comments_status');
            $table->dropColumn('default_comment_status');
        });
    }
}
