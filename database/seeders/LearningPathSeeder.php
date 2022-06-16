<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;


class LearningPathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('learning_path')->insert([
            'id_learning_path' => 1,
            'name' => "Nahwu Class",
            'desc' => "Dummy Desc",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        DB::table('learning_path')->insert([
            'id_learning_path' => 2,
            'name' => "Shorof Class",
            'desc' => "Dummy Desc",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        DB::table('learning_path')->insert([
            'id_learning_path' => 3,
            'name' => "Kaligrafi Class",
            'desc' => "Dummy Desc",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
