<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgradeDirectoratesTableAddCountryIdCoulumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('directorates', function (Blueprint $table) {
            $table->unsignedInteger('country_id')->index()->nullable()->after('user_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('directorates', function (Blueprint $table) {
            $table->dropForeign('directorates_country_id_foreign');
            $table->dropColumn('country_id');
        });
    }
}
