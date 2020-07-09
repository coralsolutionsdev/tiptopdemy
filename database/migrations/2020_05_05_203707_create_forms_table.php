<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hash_id', 400)->nullable();
            $table->string('title', 400);
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->integer('version')->default(0);
            $table->unsignedBigInteger('master_id')->nullable();
            $table->unsignedBigInteger('ancestor_id')->nullable();
            $table->text('submit_route')->nullable();
            $table->integer('type')->nullable();
            $table->tinyInteger('status');
            $table->integer('position')->nullable();
            $table->longText('properties')->nullable();
            $table->timestamp('start_at')->nullable();
            $table->timestamp('expire_at')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('forms');
    }
}
