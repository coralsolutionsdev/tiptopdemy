<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpgradeProductColumnsAddScopeColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {

            $table->unsignedInteger('color_pattern_id')->index()->nullable()->after('position');
            $table->foreign('color_pattern_id')->references('id')->on('color_patterns')->onDelete('set null');
            $table->integer('level')->nullable()->after('position');
            $table->unsignedInteger('field_option_id')->index()->nullable()->after('position');
            $table->foreign('field_option_id')->references('id')->on('institution_scope_field_options')->onDelete('set null');
            $table->unsignedInteger('field_id')->index()->nullable()->after('position');
            $table->foreign('field_id')->references('id')->on('institution_scope_fields')->onDelete('set null');
            $table->unsignedInteger('scope_id')->index()->nullable()->after('position');
            $table->foreign('scope_id')->references('id')->on('institution_scopes')->onDelete('set null');
            $table->unsignedInteger('directorate_id')->index()->nullable()->after('position');
            $table->foreign('directorate_id')->references('id')->on('directorates')->onDelete('set null');
            $table->unsignedInteger('country_id')->index()->nullable()->after('position');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('editor_id')->nullable();
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('level');
            $table->dropForeign('products_color_pattern_id_foreign');
            $table->dropColumn('color_pattern_id');
            $table->dropForeign('products_field_option_id_foreign');
            $table->dropColumn('field_option_id');
            $table->dropForeign('products_field_id_foreign');
            $table->dropColumn('field_id');
            $table->dropForeign('products_scope_id_foreign');
            $table->dropColumn('scope_id');
            $table->dropForeign('products_directorate_id_foreign');
            $table->dropColumn('directorate_id');
            $table->dropForeign('products_country_id_foreign');
            $table->dropColumn('country_id');
            $table->dropForeign('products_creator_id_foreign');
            $table->dropColumn('creator_id');
            $table->dropForeign('products_editor_id_foreign');
            $table->dropColumn('editor_id');
        });
    }
}
