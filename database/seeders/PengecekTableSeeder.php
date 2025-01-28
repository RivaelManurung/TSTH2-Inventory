<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengecekTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_pengecek')->insert([
            [
                'pengecek_id' => 4,
                'pengecek_nama' => 'Panca Sibuea',
                'pengecek_slug' => 'panca-sibuea',
                'pengecek_alamat' => null,
                'pengecek_notelp' => null,
                'created_at' => Carbon::parse('2023-12-11 21:53:08'),
                'updated_at' => Carbon::parse('2023-12-11 21:53:08'),
            ],
            [
                'pengecek_id' => 5,
                'pengecek_nama' => 'Herbinawan Nainggolan',
                'pengecek_slug' => 'herbinawan-nainggolan',
                'pengecek_alamat' => null,
                'pengecek_notelp' => null,
                'created_at' => Carbon::parse('2023-12-11 21:53:20'),
                'updated_at' => Carbon::parse('2023-12-11 21:53:20'),
            ],
            [
                'pengecek_id' => 6,
                'pengecek_nama' => 'Irvandi Sihombing',
                'pengecek_slug' => 'irvandi-sihombing',
                'pengecek_alamat' => null,
                'pengecek_notelp' => null,
                'created_at' => Carbon::parse('2023-12-12 00:12:53'),
                'updated_at' => Carbon::parse('2023-12-12 00:12:53'),
            ],
            [
                'pengecek_id' => 7,
                'pengecek_nama' => 'Lianty Simangunsong',
                'pengecek_slug' => 'lianty-simangunsong',
                'pengecek_alamat' => null,
                'pengecek_notelp' => null,
                'created_at' => Carbon::parse('2023-12-12 20:11:10'),
                'updated_at' => Carbon::parse('2023-12-12 20:11:10'),
            ],
            [
                'pengecek_id' => 8,
                'pengecek_nama' => 'Joy Damanik',
                'pengecek_slug' => 'joy-damanik',
                'pengecek_alamat' => null,
                'pengecek_notelp' => null,
                'created_at' => Carbon::parse('2023-12-12 20:11:20'),
                'updated_at' => Carbon::parse('2023-12-12 20:11:20'),
            ],
            [
                'pengecek_id' => 10,
                'pengecek_nama' => 'Mutiara Silitonga',
                'pengecek_slug' => 'mutiara-silitonga',
                'pengecek_alamat' => null,
                'pengecek_notelp' => null,
                'created_at' => Carbon::parse('2023-12-13 00:50:27'),
                'updated_at' => Carbon::parse('2023-12-13 00:50:27'),
            ],
            [
                'pengecek_id' => 12,
                'pengecek_nama' => 'Boi',
                'pengecek_slug' => 'boi',
                'pengecek_alamat' => null,
                'pengecek_notelp' => null,
                'created_at' => Carbon::parse('2024-02-25 23:41:43'),
                'updated_at' => Carbon::parse('2024-02-26 13:40:55'),
            ],
            [
                'pengecek_id' => 13,
                'pengecek_nama' => 'Dattita',
                'pengecek_slug' => 'dattita',
                'pengecek_alamat' => null,
                'pengecek_notelp' => null,
                'created_at' => Carbon::parse('2024-02-25 23:41:49'),
                'updated_at' => Carbon::parse('2024-02-26 13:41:09'),
            ],
            [
                'pengecek_id' => 14,
                'pengecek_nama' => 'Sri Fani',
                'pengecek_slug' => 'sri-fani',
                'pengecek_alamat' => null,
                'pengecek_notelp' => null,
                'created_at' => Carbon::parse('2024-03-26 10:03:22'),
                'updated_at' => Carbon::parse('2024-03-26 10:03:22'),
            ],
        ]);
    }
}