<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributeOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_options', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_attribute_id')->index()->nullable();
            $table->foreign('product_attribute_id')->references('id')->on('product_attributes')->onDelete('set null');
            $table->string('name')->index();
            $table->string('value')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_default')->default(false);
            $table->unique(['product_attribute_id', 'name']);
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
        Schema::dropIfExists('product_attribute_options');
    }
}
