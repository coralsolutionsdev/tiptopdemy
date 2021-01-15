<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//        $this->call('SiteTableSeeder');
        $this->call(LaratrustSeeder::class);
//        $this->call('CountriesSeeder');
//        $this->call('CompanySeeder');
        $this->call('ColorPatternSeeder');

    }
}
