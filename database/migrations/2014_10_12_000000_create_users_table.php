<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('email')->unique();
            $table->boolean('gender')->default(1);
            $table->integer('phone_number')->nullable();
            $table->timestamp('birth_Date')->nullable();
            $table->string('avatar')->nullable();
            $table->string('cover')->nullable();
            $table->string('lang')->nullable();
            $table->string('verify_token')->nullable();
            $table->boolean('status')->default(0);
            $table->string('password');
            $table->integer('country_id')->nullable();
//            $table->unsignedInteger('country_id')->index()->nullable();
//            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            // TipTop fields
            $table->unsignedInteger('directorate_id')->index()->nullable();
            $table->foreign('directorate_id')->references('id')->on('directorates')->onDelete('set null');
            $table->unsignedInteger('scope_id')->index()->nullable();
            $table->foreign('scope_id')->references('id')->on('institution_scopes')->onDelete('set null');
            $table->unsignedInteger('field_id')->index()->nullable();
            $table->foreign('field_id')->references('id')->on('institution_scope_fields')->onDelete('set null');
            $table->unsignedInteger('field_option_id')->index()->nullable();
            $table->foreign('field_option_id')->references('id')->on('institution_scope_field_options')->onDelete('set null');
            $table->integer('level')->nullable();
            // end of TipTop fields
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('users');
    }
}
