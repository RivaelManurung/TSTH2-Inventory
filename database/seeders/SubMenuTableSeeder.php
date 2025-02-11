<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SubMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_submenu')->insert([
            [
                'submenu_id' => 9,
                'menu_id' => 1668510437,
                'submenu_judul' => 'Barang Masuk',
                'submenu_slug' => 'barang-masuk',
                'submenu_redirect' => '/barang-masuk',
                'submenu_sort' => 1,
                'created_at' => Carbon::create(2022, 11, 15, 11, 8, 19),
                'updated_at' => Carbon::create(2022, 11, 15, 11, 8, 19),
            ],
            [
                'submenu_id' => 10,
                'menu_id' => 1668510437,
                'submenu_judul' => 'Barang Keluar',
                'submenu_slug' => 'barang-keluar',
                'submenu_redirect' => '/barang-keluar',
                'submenu_sort' => 2,
                'created_at' => Carbon::create(2022, 11, 15, 11, 8, 19),
                'updated_at' => Carbon::create(2022, 11, 15, 11, 8, 19),
            ],
            [
                'submenu_id' => 17,
                'menu_id' => 1668509889,
                'submenu_judul' => 'Jenis',
                'submenu_slug' => 'jenis',
                'submenu_redirect' => '/jenisbarang',
                'submenu_sort' => 1,
                'created_at' => Carbon::create(2022, 11, 24, 12, 6, 48),
                'updated_at' => Carbon::create(2022, 11, 24, 12, 6, 48),
            ],
            [
                'submenu_id' => 18,
                'menu_id' => 1668509889,
                'submenu_judul' => 'Satuan',
                'submenu_slug' => 'satuan',
                'submenu_redirect' => '/satuan',
                'submenu_sort' => 2,
                'created_at' => Carbon::create(2022, 11, 24, 12, 6, 48),
                'updated_at' => Carbon::create(2022, 11, 24, 12, 6, 48),
            ],
            [
                'submenu_id' => 19,
                'menu_id' => 1668509889,
                'submenu_judul' => 'Gudang',
                'submenu_slug' => 'gudang',
                'submenu_redirect' => '/gudang',
                'submenu_sort' => 3,
                'created_at' => Carbon::create(2022, 11, 24, 12, 6, 48),
                'updated_at' => Carbon::create(2022, 11, 24, 12, 6, 48),
            ],
            [
                'submenu_id' => 20,
                'menu_id' => 1668509889,
                'submenu_judul' => 'Barang',
                'submenu_slug' => 'barang',
                'submenu_redirect' => '/barang',
                'submenu_sort' => 4,
                'created_at' => Carbon::create(2022, 11, 24, 12, 6, 48),
                'updated_at' => Carbon::create(2022, 11, 24, 12, 6, 48),
            ],
            [
                'submenu_id' => 21,
                'menu_id' => 1668510568,
                'submenu_judul' => 'Lap Barang Masuk',
                'submenu_slug' => 'lap-barang-masuk',
                'submenu_redirect' => '/lap-barang-masuk',
                'submenu_sort' => 1,
                'created_at' => Carbon::create(2022, 11, 30, 12, 56, 24),
                'updated_at' => Carbon::create(2022, 11, 30, 12, 56, 24),
            ],
            [
                'submenu_id' => 22,
                'menu_id' => 1668510568,
                'submenu_judul' => 'Lap Barang Keluar',
                'submenu_slug' => 'lap-barang-keluar',
                'submenu_redirect' => '/lap-barang-keluar',
                'submenu_sort' => 2,
                'created_at' => Carbon::create(2022, 11, 30, 12, 56, 24),
                'updated_at' => Carbon::create(2022, 11, 30, 12, 56, 24),
            ],
            [
                'submenu_id' => 23,
                'menu_id' => 1668510568,
                'submenu_judul' => 'Lap Stok Barang',
                'submenu_slug' => 'lap-stok-barang',
                'submenu_redirect' => '/lap-stok-barang',
                'submenu_sort' => 3,
                'created_at' => Carbon::create(2022, 11, 30, 12, 56, 24),
                'updated_at' => Carbon::create(2022, 11, 30, 12, 56, 24),
            ],
        ]);
    }
}
