<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 400);
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('ancestor_id')->nullable();
            $table->foreign('ancestor_id')->references('id')->on('lists')->onDelete('cascade');
            $table->integer('position')->nullable();
            $table->integer('type')->nullable();
            $table->string('owner_type');
            $table->unsignedBigInteger('owner_id')->index();
            $table->unsignedBigInteger('color_pattern_id')->nullable();
            $table->foreign('color_pattern_id')->references('id')->on('color_patterns')->onDelete('cascade');
            $table->tinyInteger('status');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('groups');
    }
}
