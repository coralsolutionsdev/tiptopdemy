<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProductAttributePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_attribute', function (Blueprint $table) {
            $table->unsignedInteger('product_id')->index()->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            $table->unsignedInteger('product_attribute_id')->index()->nullable();
            $table->foreign('product_attribute_id', 'product_attribute_id_foreign')->references('id')->on('product_attributes')->onDelete('set null');
            $table->string ('value')->nullable();
            $table->primary(['product_id', 'product_attribute_id'], 'product_product_attribute_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_product_attribute');
    }
}
