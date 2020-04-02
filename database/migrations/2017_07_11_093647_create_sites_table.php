<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('logo')->nullable();
            $table->integer('logo_show')->default(0);
            $table->text('description')->nullable();
            $table->string('lang');
            $table->unsignedInteger('layout_id')->nullable();
            $table->foreign('layout_id')->references('id')->on('layouts')->onDelete('set null');
            $table->string('theme');
            $table->string('admin_theme');
            $table->boolean('active');
            $table->boolean('registration');
            $table->boolean('installed');
            $table->boolean('simple_data');
            $table->decimal('version');
            $table->unsignedInteger('contact_id')->index()->nullable();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('set null');
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
        Schema::dropIfExists('sites');
    }
}
