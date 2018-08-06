<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BuildCompetitionThemeDivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \DB::table('build_competition_theme_division')->truncate();


        \DB::table('build_competition_theme_division')->insert([
            'theme_division_id'   => 1,
            'build_competition_group' => 4,
            'theme_division_name' => '和風',
            'glyphicon' => 'glyphicon-tree-deciduous',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \DB::table('build_competition_theme_division')->insert([
            'theme_division_id'   => 2,
            'build_competition_group' => 4,
            'theme_division_name' => 'ファンタジー',
            'glyphicon' => 'glyphicon-leaf',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \DB::table('build_competition_theme_division')->insert([
            'theme_division_id'   => 3,
            'build_competition_group' => 4,
            'theme_division_name' => '洋風',
            'glyphicon' => 'glyphicon-knight',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        \DB::table('build_competition_theme_division')->insert([
            'theme_division_id'   => 4,
            'build_competition_group' => 4,
            'theme_division_name' => 'モダン',
            'glyphicon' => 'glyphicon-picture',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
