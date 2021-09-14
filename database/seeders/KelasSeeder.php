<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $level = ["Pemula", "Menengah", "Lanjutan", "Ahli"];

        for($i = 0; $i < 3; $i++) {
            DB::table('kelas')->insert([
                'id_kategori' => random_int(1, 10),
                'id_reviewer' => random_int(1, 10),
                'judul' => Str::random(7),
                'gambar' => Str::random(4) . ".jpg",
                'langkah' => random_int(3, 7),
                'level' => $level[random_int(0, 3)],
                'deskripsi_singkat' => Str::random(30),
                'durasi' => random_int(1, 20),
                'deskripsi_kelas' => Str::random(40),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
    }
}
