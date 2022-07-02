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
        DB::table('kelas_user')->insert([
            'id_kelas' => random_int(1, 2),
            'id_user' => 1,
            'point_review' => random_int(4, 5),
            'komentar_review' => "The mentor is cool, the way he conv-eys each material is also detailed and easy to reach and the featured really make easy to learn arabic. Words can not describe this class!",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
