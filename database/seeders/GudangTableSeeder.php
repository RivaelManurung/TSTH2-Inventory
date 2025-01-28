<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GudangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_gudang')->insert([
            [
                'gudang_id' => 9,
                'gudang_nama' => 'Gudang Pertama TSTH2 Aek Nauli',
                'gudang_slug' => 'gudang-pertama-tsth2-aek-nauli',
                'gudang_keterangan' => NULL,
                'created_at' => '2024-02-20 08:13:46',
                'updated_at' => '2024-02-20 08:13:46',
            ],
            [
                'gudang_id' => 10,
                'gudang_nama' => 'Gudang Kedua TSTH2 Aek Nauli',
                'gudang_slug' => 'gudang-kedua-tsth2-aek-nauli',
                'gudang_keterangan' => NULL,
                'created_at' => '2024-02-20 08:14:04',
                'updated_at' => '2024-02-20 08:14:04',
            ],
            [
                'gudang_id' => 11,
                'gudang_nama' => 'Gudang Ketiga TSTH2 Aek Nauli',
                'gudang_slug' => 'gudang-ketiga-tsth2-aek-nauli',
                'gudang_keterangan' => NULL,
                'created_at' => '2024-02-20 08:16:20',
                'updated_at' => '2024-02-20 08:16:20',
            ],
            [
                'gudang_id' => 12,
                'gudang_nama' => 'Gudang Pertama Food Estate',
                'gudang_slug' => 'gudang-pertama-food-estate',
                'gudang_keterangan' => NULL,
                'created_at' => '2024-03-11 20:27:20',
                'updated_at' => '2024-03-11 20:27:20',
            ],
            [
                'gudang_id' => 13,
                'gudang_nama' => 'Lainnya(Lapangan)',
                'gudang_slug' => 'lainnya-lapangan-',
                'gudang_keterangan' => NULL,
                'created_at' => '2024-03-15 10:17:39',
                'updated_at' => '2024-03-15 10:17:39',
            ],
            [
                'gudang_id' => 15,
                'gudang_nama' => 'Gudang Utilitas',
                'gudang_slug' => 'gudang-utilitas',
                'gudang_keterangan' => NULL,
                'created_at' => '2024-05-10 11:20:57',
                'updated_at' => '2024-05-10 11:20:57',
            ],
            [
                'gudang_id' => 16,
                'gudang_nama' => 'Rusun',
                'gudang_slug' => 'rusun',
                'gudang_keterangan' => NULL,
                'created_at' => '2024-06-06 14:37:51',
                'updated_at' => '2024-06-06 14:37:51',
            ],
        ]);
    }
}