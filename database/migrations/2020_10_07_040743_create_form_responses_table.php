<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('form_responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 400)->nullable();
            $table->text('description')->nullable();
            $table->string('hash_id', 400)->nullable();
            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->unsignedBigInteger('ancestor_id')->nullable();
            $table->foreign('ancestor_id')->references('id')->on('forms')->onDelete('cascade');
            $table->text('responder_info')->nullable();
            $table->longText('data')->nullable();
            $table->text('properties')->nullable();
            $table->tinyInteger('status');
            $table->integer('type')->nullable();
            $table->text('score_info')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_responses');
    }
}
