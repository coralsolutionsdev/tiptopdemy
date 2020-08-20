<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdAndCreatorIdColumnsToCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->after('description')->nullable();
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            $table->unsignedBigInteger('editor_id')->after('images')->nullable();
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('creator_id')->after('images')->nullable();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign('categories_company_id_foreign');
            $table->dropColumn('company_id');
            $table->dropForeign('categories_editor_id_foreign');
            $table->dropColumn('editor_id');
            $table->dropForeign('categories_creator_id_foreign');
            $table->dropColumn('creator_id');
        });
    }
}
