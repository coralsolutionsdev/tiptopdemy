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
            'display_name' => 'banners'
        ]);
        Module::create([
            'name' => 'blog_posts',
            'display_name' => 'blog'
        ]);
        Module::create([
            'name' => 'gallery_images',
            'display_name' => 'gallery'
        ]);
        Module::create([
            'name' => 'messages',
            'display_name' => 'messages'
        ]);
        Module::create([
            'name' => 'pages',
            'display_name' => 'pages'
        ]);
        Module::create([
            'name' => 'store',
            'display_name' => 'store'
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
