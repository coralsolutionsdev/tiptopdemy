<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Site;

class SiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $theme = [
            'theme_name' => 'coral_light',
            'primary_color' => '#2196F3',
            'framework' => Site::THEME_FRAMEWORK_UIKIT
        ];
        $admin_theme = [
            'theme_name' => 'coral_admin',
            'primary_color' => '#2196F3',
            'framework' => Site::THEME_FRAMEWORK_BOOTSTRAP
        ];
        DB::table('sites')->insert([
            'name'=>'coral',
            'description'=>'coral',
            'lang'=>'en',
            'theme'=> json_encode($theme),
            'admin_theme'=> json_encode($admin_theme),
            'active'=>'0',
            'registration'=>'1',
            'installed'=>'1',
            'simple_data'=>'0',
            'version'=>'1.0',
        ]);
    }
}
