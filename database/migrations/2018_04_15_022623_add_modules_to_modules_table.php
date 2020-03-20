<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Module;

class AddModulesToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Module::create([
            'name' => 'banners',
            'display_name' => 'Banners'
        ]);
        Module::create([
            'name' => 'blog_posts',
            'display_name' => 'Blog'
        ]);
        Module::create([
            'name' => 'gallery_images',
            'display_name' => 'Gallery'
        ]);
        Module::create([
            'name' => 'messages',
            'display_name' => 'Messages'
        ]);
        Module::create([
            'name' => 'pages',
            'display_name' => 'Pages'
        ]);
        Module::create([
            'name' => 'layouts',
            'display_name' => 'Layouts'
        ]);
        Module::create([
            'name' => 'products',
            'display_name' => 'Store'
        ]);
        Module::create([
            'name' => 'appointments',
            'display_name' => 'Appointments'
        ]);
        Module::create([
            'name' => 'companies',
            'display_name' => 'Companies'
        ]);
        Module::create([
            'name' => 'contacts',
            'display_name' => 'Contacts'
        ]);
        Module::create([
            'name' => 'institutions',
            'display_name' => 'Institutions'
        ]);
        Module::create([
            'name' => 'directorates',
            'display_name' => 'Directorates'
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
