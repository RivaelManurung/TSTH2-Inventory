<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_user')->insert([
            [
                'role_id' => 1,
                'user_nmlengkap' => 'Super Administrator',
                'user_nama' => 'superadmin',
                'user_email' => 'superadmin@gmail.com',
                'user_foto' => 'undraw_profile.svg',
                'user_password' => Hash::make('12345678'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'role_id' => 2,
                'user_nmlengkap' => 'Administrator',
                'user_nama' => 'admin',
                'user_email' => 'admin@gmail.com',
                'user_foto' => 'undraw_profile.svg',
                'user_password' => Hash::make('12345678'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'role_id' => 3,
                'user_nmlengkap' => 'Operator',
                'user_nama' => 'operator',
                'user_email' => 'operator@gmail.com',
                'user_foto' => 'undraw_profile.svg',
                'user_password' => Hash::make('12345678'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
        ]);
    }
}
