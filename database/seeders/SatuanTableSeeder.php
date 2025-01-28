<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SatuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_satuan')->insert([
            [
                'satuan_id' => 9,
                'satuan_nama' => 'Gulung',
                'satuan_slug' => 'gulung',
                'satuan_keterangan' => NULL,
                'created_at' => '2023-12-10 23:31:33',
                'updated_at' => '2023-12-10 23:31:33',
            ],
            [
                'satuan_id' => 10,
                'satuan_nama' => 'Unit',
                'satuan_slug' => 'unit',
                'satuan_keterangan' => NULL,
                'created_at' => '2023-12-10 23:32:23',
                'updated_at' => '2023-12-10 23:32:23',
            ],
            [
                'satuan_id' => 11,
                'satuan_nama' => 'Kg',
                'satuan_slug' => 'kg',
                'satuan_keterangan' => NULL,
                'created_at' => '2023-12-10 23:43:22',
                'updated_at' => '2023-12-10 23:43:22',
            ],
            [
                'satuan_id' => 12,
                'satuan_nama' => 'Gram',
                'satuan_slug' => 'gram',
                'satuan_keterangan' => NULL,
                'created_at' => '2023-12-10 23:43:28',
                'updated_at' => '2023-12-11 23:14:45',
            ],
            [
                'satuan_id' => 13,
                'satuan_nama' => 'Mililiter',
                'satuan_slug' => 'mililiter',
                'satuan_keterangan' => NULL,
                'created_at' => '2023-12-10 23:45:57',
                'updated_at' => '2023-12-11 23:14:39',
            ],
            [
                'satuan_id' => 14,
                'satuan_nama' => 'Liter',
                'satuan_slug' => 'liter',
                'satuan_keterangan' => NULL,
                'created_at' => '2023-12-11 23:14:31',
                'updated_at' => '2023-12-11 23:14:31',
            ],
            [
                'satuan_id' => 15,
                'satuan_nama' => 'Buah',
                'satuan_slug' => 'buah',
                'satuan_keterangan' => NULL,
                'created_at' => '2024-04-17 13:53:54',
                'updated_at' => '2024-04-17 13:53:54',
            ],
        ]);
    }
}