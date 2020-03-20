<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniqueIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unique_ids', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('module_id')->index()->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('set null');
            $table->integer('unique_id');
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
        Schema::dropIfExists('unique_ids');
    }
}
