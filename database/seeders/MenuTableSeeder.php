    <?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;

    class MenuTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            DB::table('tbl_menu')->insert(
                [
                    [
                        'menu_id' => 1667444041,
                        'menu_judul' => 'Beranda',
                        'menu_slug' => 'beranda',
                        'menu_icon' => 'home',
                        'menu_redirect' => '/beranda',
                        'menu_sort' => 1,
                        'menu_type' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'menu_id' => 1668509889,
                        'menu_judul' => 'Master Barang',
                        'menu_slug' => 'master-barang',
                        'menu_icon' => 'package',
                        'menu_redirect' => '-',
                        'menu_sort' => 4,
                        'menu_type' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'menu_id' => 1668510437,
                        'menu_judul' => 'Transaksi',
                        'menu_slug' => 'transaksi',
                        'menu_icon' => 'repeat',
                        'menu_redirect' => '-',
                        'menu_sort' => 2,
                        'menu_type' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'menu_id' => 1668510568,
                        'menu_judul' => 'Laporan',
                        'menu_slug' => 'laporan',
                        'menu_icon' => 'printer',
                        'menu_redirect' => '-',
                        'menu_sort' => 5,
                        'menu_type' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'menu_id' => 1669390641,
                        'menu_judul' => 'Pengecek',
                        'menu_slug' => 'pengecek',
                        'menu_icon' => 'user',
                        'menu_redirect' => '/pengecek',
                        'menu_sort' => 3,
                        'menu_type' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ]
            );
        }
    }
