<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->nullable();
            $table->text('description');
            $table->integer('industry');
            $table->text('emails');
            $table->text('phone_numbers');
            $table->text('faxes');
            $table->text('addresses');
            $table->integer('postcode');
            $table->string('city');
            $table->string('state');
            $table->string('country_code');
            $table->text('vision');
            $table->text('mission');
            $table->text('leave_Settings');
            $table->tinyInteger('status');
            $table->string('logo');
            $table->string('dropbox_token');
            $table->string('website');
            $table->text('old_email_data');
            $table->integer('company_size');
            $table->string('registration_no');
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
        Schema::dropIfExists('companies');
    }
}
