<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFormIdToNullableInFormItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('form_items', function (Blueprint $table) {
            $table->unsignedBigInteger('form_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_items', function (Blueprint $table) {
            $table->unsignedBigInteger('form_id')->nullable(false)->change();
        });
    }
}
