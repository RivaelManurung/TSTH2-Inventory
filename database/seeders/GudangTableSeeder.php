<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class GudangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $gudangs = [
            [
                'gudang_id' => 9,
                'gudang_nama' => 'Gudang Pertama TSTH2 Aek Nauli',
                'gudang_slug' => 'gudang-pertama-tsth2-aek-nauli',
                'gudang_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 10,
                'gudang_nama' => 'Gudang Kedua TSTH2 Aek Nauli',
                'gudang_slug' => 'gudang-kedua-tsth2-aek-nauli',
                'gudang_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 11,
                'gudang_nama' => 'Gudang Ketiga TSTH2 Aek Nauli',
                'gudang_slug' => 'gudang-ketiga-tsth2-aek-nauli',
                'gudang_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 12,
                'gudang_nama' => 'Gudang Pertama Food Estate',
                'gudang_slug' => 'gudang-pertama-food-estate',
                'gudang_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 13,
                'gudang_nama' => 'Lainnya (Lapangan)',
                'gudang_slug' => 'lainnya-lapangan',
                'gudang_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 15,
                'gudang_nama' => 'Gudang Utilitas',
                'gudang_slug' => 'gudang-utilitas',
                'gudang_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 16,
                'gudang_nama' => 'Rusun',
                'gudang_slug' => 'rusun',
                'gudang_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        DB::table('tbl_gudang')->insert($gudangs);
    }
}
