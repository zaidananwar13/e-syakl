<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = [
            [
                'judul' => 'Nahwu',
                'gambar' => 'nahwu.jpg',
                'deskripsi' => 'Kategori untuk pembelajaran nahwu',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'judul' => 'Sorof',
                'gambar' => 'sorof.jpg',
                'deskripsi' => 'Kategori untuk pembelajaran sorof',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'judul' => 'Kaligrafi',
                'gambar' => 'kaligrafi.jpg',
                'deskripsi' => 'Kategori untuk pembelajaran kaligrafi',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        foreach($kategori as $k) {
            DB::table('kategori')->insert($k);
        }
    }
}
