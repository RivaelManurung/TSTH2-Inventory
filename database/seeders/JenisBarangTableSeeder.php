<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class JenisBarangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_jenisbarang')->insert([
            [
                'jenisbarang_id' => 14,
                'jenisbarang_nama' => 'Perkakas',
                'jenisbarang_slug' => 'perkakas',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-10 23:29:04',
                'updated_at' => '2023-12-10 23:29:04',
            ],
            [
                'jenisbarang_id' => 18,
                'jenisbarang_nama' => 'Fungisida',
                'jenisbarang_slug' => 'fungisida',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:12:31',
                'updated_at' => '2023-12-11 23:12:31',
            ],
            [
                'jenisbarang_id' => 19,
                'jenisbarang_nama' => 'Insektisida',
                'jenisbarang_slug' => 'insektisida',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:12:41',
                'updated_at' => '2023-12-11 23:12:41',
            ],
            [
                'jenisbarang_id' => 20,
                'jenisbarang_nama' => 'Herbisida',
                'jenisbarang_slug' => 'herbisida',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:13:29',
                'updated_at' => '2023-12-11 23:13:29',
            ],
            [
                'jenisbarang_id' => 21,
                'jenisbarang_nama' => 'Bakterisida',
                'jenisbarang_slug' => 'bakterisida',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:13:47',
                'updated_at' => '2023-12-11 23:13:47',
            ],
            [
                'jenisbarang_id' => 22,
                'jenisbarang_nama' => 'Rodentisida',
                'jenisbarang_slug' => 'rodentisida',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:13:55',
                'updated_at' => '2023-12-11 23:13:55',
            ],
            [
                'jenisbarang_id' => 23,
                'jenisbarang_nama' => 'Moluskisida',
                'jenisbarang_slug' => 'moluskisida',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:14:07',
                'updated_at' => '2023-12-11 23:14:07',
            ],
            [
                'jenisbarang_id' => 24,
                'jenisbarang_nama' => 'Nematisida',
                'jenisbarang_slug' => 'nematisida',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:14:16',
                'updated_at' => '2023-12-11 23:14:16',
            ],
            [
                'jenisbarang_id' => 25,
                'jenisbarang_nama' => 'Pupuk',
                'jenisbarang_slug' => 'pupuk',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:16:57',
                'updated_at' => '2023-12-11 23:16:57',
            ],
            [
                'jenisbarang_id' => 26,
                'jenisbarang_nama' => 'Bahan Bakar',
                'jenisbarang_slug' => 'bahan-bakar',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:18:59',
                'updated_at' => '2023-12-11 23:18:59',
            ],
            [
                'jenisbarang_id' => 27,
                'jenisbarang_nama' => 'Keperluan Lapangan',
                'jenisbarang_slug' => 'keperluan-lapangan',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:19:59',
                'updated_at' => '2023-12-11 23:19:59',
            ],
            [
                'jenisbarang_id' => 28,
                'jenisbarang_nama' => 'Perekat & Perata',
                'jenisbarang_slug' => 'perekat-perata',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-11 23:59:48',
                'updated_at' => '2023-12-11 23:59:48',
            ],
            [
                'jenisbarang_id' => 29,
                'jenisbarang_nama' => 'Bakterisida & Fungisida',
                'jenisbarang_slug' => 'bakterisida-fungisida',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-12 00:00:56',
                'updated_at' => '2023-12-12 00:00:56',
            ],
            [
                'jenisbarang_id' => 30,
                'jenisbarang_nama' => 'Zat Pengatur Tumbuh',
                'jenisbarang_slug' => 'zat-pengatur-tumbuh',
                'jenisbarang_ket' => NULL,
                'created_at' => '2023-12-12 00:05:31',
                'updated_at' => '2024-02-26 13:33:11',
            ],
            [
                'jenisbarang_id' => 31,
                'jenisbarang_nama' => 'Mikroba',
                'jenisbarang_slug' => 'mikroba',
                'jenisbarang_ket' => NULL,
                'created_at' => '2024-02-26 13:33:44',
                'updated_at' => '2024-02-26 13:33:44',
            ],
            [
                'jenisbarang_id' => 32,
                'jenisbarang_nama' => 'Insektisida & Nematisida',
                'jenisbarang_slug' => 'insektisida-nematisida',
                'jenisbarang_ket' => NULL,
                'created_at' => '2024-03-15 13:55:32',
                'updated_at' => '2024-03-15 13:55:32',
            ],
            [
                'jenisbarang_id' => 33,
                'jenisbarang_nama' => 'Barang Satpam',
                'jenisbarang_slug' => 'barang-satpam',
                'jenisbarang_ket' => NULL,
                'created_at' => '2024-04-17 13:53:07',
                'updated_at' => '2024-04-17 13:53:07',
            ],
            [
                'jenisbarang_id' => 34,
                'jenisbarang_nama' => 'Bio-Sterilisasi/Aerob Decomposer',
                'jenisbarang_slug' => 'bio-sterilisasi-aerob-decomposer',
                'jenisbarang_ket' => NULL,
                'created_at' => '2024-05-10 11:20:07',
                'updated_at' => '2024-05-10 11:20:07',
            ],
        ]);
    }
}