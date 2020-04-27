<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            // auth commenter
            $table->string('commenter_type')->nullable()->index();
            $table->string('commenter_id')->nullable()->index();
            // guest commenter
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            // commentable model
            $table->string("commentable_type")->index();
            $table->string("commentable_id")->index();
//            $table->index(["commentable_type", "commentable_id"]);
            // comment
            $table->text('comment');
            $table->tinyInteger('status')->default(1);
            // parent
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
