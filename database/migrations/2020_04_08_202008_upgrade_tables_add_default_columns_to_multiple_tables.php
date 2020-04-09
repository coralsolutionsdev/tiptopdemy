<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpgradeTablesAddDefaultColumnsToMultipleTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // directorates
        Schema::table('directorates', function (Blueprint $table) {
            $table->tinyInteger('default')->nullable()->after('position');
        });
        // institution_scopes
        Schema::table('institution_scopes', function (Blueprint $table) {
            $table->tinyInteger('default')->nullable()->after('position');
        });
        // institution_scope_fields
        Schema::table('institution_scope_fields', function (Blueprint $table) {
            $table->text('levels')->nullable()->after('position');
        });
        // institution_scope_fields
        Schema::table('institution_scope_fields', function (Blueprint $table) {
            $table->tinyInteger('default')->nullable()->after('position');
        });
        // institution_scope_field_options
        Schema::table('institution_scope_field_options', function (Blueprint $table) {
            $table->tinyInteger('default')->nullable()->after('position');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // directorates
        Schema::table('directorates', function (Blueprint $table) {
            $table->dropColumn('default');
        });
        // institution_scopes
        Schema::table('institution_scopes', function (Blueprint $table) {
            $table->dropColumn('default');
        });
        // institution_scope_fields
        Schema::table('institution_scope_fields', function (Blueprint $table) {
            $table->dropColumn('levels');
        });
        // institution_scope_fields
        Schema::table('institution_scope_fields', function (Blueprint $table) {
            $table->dropColumn('default');
        });
        // institution_scope_field_options
        Schema::table('institution_scope_field_options', function (Blueprint $table) {
            $table->dropColumn('default');
        });

    }
}
