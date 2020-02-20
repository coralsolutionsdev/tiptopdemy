<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('sku')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('manage_stock');
            $table->integer('quantity')->nullable();
            $table->string('currency')->nullable();
            $table->decimal('price', 40, 2)->default(0);
            $table->decimal('retail_price', 40, 2)->default(0);
            $table->decimal('special_price', 40, 2)->default(0);
            $table->timestamp('special_price_from')->nullable();
            $table->timestamp('special_price_to')->nullable();
            $table->unsignedInteger('product_type_id')->index()->nullable();
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('set null');
            $table->unsignedInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->tinyInteger('status');
            $table->string('qr_path')->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->text('images')->nullable();
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
        Schema::dropIfExists('products');
    }
}
