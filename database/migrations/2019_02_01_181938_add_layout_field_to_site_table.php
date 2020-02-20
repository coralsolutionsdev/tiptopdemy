<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLayoutFieldToSiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->unsignedInteger('layout_id')->nullable()->after('theme');
            $table->foreign('layout_id')->references('id')->on('layouts')->onDelete('set null');
            $table->string('admin_theme')->after('theme');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropForeign('sites_layout_id_foreign');
            $table->dropColumn('layout_id');
            $table->dropColumn('admin_theme');
        });
    }
}
