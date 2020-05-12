<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorPatternsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_patterns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 400);
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('pattern')->nullable();
            $table->text('gradient')->nullable();
            $table->integer('angle')->nullable();
            $table->tinyInteger('default')->nullable();
            $table->tinyInteger('status');
            $table->integer('position')->nullable();
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
        Schema::dropIfExists('color_patterns');
    }
}
