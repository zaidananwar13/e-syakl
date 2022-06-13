<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Kelas_userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i = 0; $i < 10; $i++) {
            DB::table('kelas_user')->insert([
                'id_kelas' => random_int(7, 8),
                'id_user' => random_int(1, 3),
                'point_review' => random_int(1, 5),
                'komentar_review' => Str::random(18),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
