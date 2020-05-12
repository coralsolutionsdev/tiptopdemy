<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ColorPatternSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('color_patterns')->insert([
            'title'=> 'Blue wave',
            'slug'=> 'blue-wave',
            'description'=> 'blue color',
            'pattern'=> '',
            'gradient'=> json_encode([
                0 => '#637bff',
                1 => '#21c8f6',
            ]),
            'angle'=> '0',
            'default' => 1,
            'status'=> 1,
            'position'=> 0,
            'creator_id'=> 1,
        ]);

        DB::table('color_patterns')->insert([
            'title'=> 'Red wave',
            'slug'=> 'red-wave',
            'description'=> 'red color',
            'pattern'=> '',
            'gradient'=> json_encode([
                0 => '#ec454f',
                1 => '#f44881',
            ]),
            'angle'=> '0',
            'default' => 0,
            'status'=> 1,
            'position'=> 0,
            'creator_id'=> 1,
        ]);
        DB::table('color_patterns')->insert([
            'title'=> 'Green wave',
            'slug'=> 'green-wave',
            'description'=> 'Green color',
            'pattern'=> '',
            'gradient'=> json_encode([
                0 => '#1aab8b',
                1 => '#6edcc4',
            ]),
            'angle'=> '0',
            'default' => 0,
            'status'=> 1,
            'position'=> 0,
            'creator_id'=> 1,
        ]);
        DB::table('color_patterns')->insert([
            'title'=> 'Orange wave',
            'slug'=> 'orange-wave',
            'description'=> 'Green color',
            'pattern'=> '',
            'gradient'=> json_encode([
                0 => '#f19a1a',
                1 => '#ffc73c',
            ]),
            'angle'=> '0',
            'default' => 0,
            'status'=> 1,
            'position'=> 0,
            'creator_id'=> 1,
        ]);
        DB::table('color_patterns')->insert([
            'title'=> 'Purple wave',
            'slug'=> 'purple-wave',
            'description'=> 'Green color',
            'pattern'=> '',
            'gradient'=> json_encode([
                0 => '#b372bd',
                1 => '#8b60ed',
            ]),
            'angle'=> '0',
            'default' => 0,
            'status'=> 1,
            'position'=> 0,
            'creator_id'=> 1,
        ]);
    }
}
