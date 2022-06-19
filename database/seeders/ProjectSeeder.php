<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('project')->insert([
            'id_kelas' => 1,
            'judul' => "Project Kecil-kecilan",
            'deskripsi' => "Ini project 1",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        
        DB::table('project')->insert([
            'id_kelas' => 2,
            'judul' => "Project Kecil-kecilan",
            'deskripsi' => "Ini project 1",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        
        DB::table('project')->insert([
            'id_kelas' => 3,
            'judul' => "Project Kecil-kecilan",
            'deskripsi' => "Ini project 1",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
