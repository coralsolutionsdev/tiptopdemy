<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->unsignedInteger('product_attribute_set_id')->index()->nullable();
            $table->foreign('product_attribute_set_id')->references('id')->on('product_attribute_sets')->onDelete('set null');
            $table->unsignedInteger('position')->default(0);
            $table->string('default')->nullable();
            $table->tinyInteger('type');
            $table->tinyInteger('show_on_edit');
            $table->tinyInteger('show_on_frontend');
            $table->tinyInteger('filterable');
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
        Schema::dropIfExists('product_attributes');
    }
}
