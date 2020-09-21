<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('invoice_number');
            $table->timestamp('date')->nullable();
            $table->timestamp('date_paid')->nullable();
            $table->string('customer_name', 400)->nullable();
            $table->string('customer_phone_number', 400)->nullable();
            $table->string('billing_company_name', 400)->nullable();
            $table->text('billing_address')->nullable();
            $table->string('billing_city', 400)->nullable();
            $table->string('billing_state', 400)->nullable();
            $table->integer('billing_postcode')->nullable();
            $table->string('billing_country', 400)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status');
            $table->integer('type')->nullable();
            $table->string('currency', 3);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->default(0);
            $table->integer('discount_type')->nullable();
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->text('taxes')->nullable();
            $table->integer('payment_method')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('invoices');
    }
}
