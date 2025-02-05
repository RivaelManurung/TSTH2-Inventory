<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Spatie\Permission\Models\Role; // Import the Role model
use App\Models\UserModel; // Import the User model

class UserSeeder extends Seeder
{
    public function run()
    {
        // Ensure roles exist before assigning them to users
        $superAdminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $operatorRole = Role::firstOrCreate(['name' => 'operator']);

        // Insert users and assign roles
        UserModel::create([
            'user_nmlengkap' => 'Super Administrator',
            'user_nama' => 'superadmin',
            'user_email' => 'superadmin@gmail.com',
            'user_foto' => 'undraw_profile.svg',
            'user_password' => Hash::make('12345678'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ])->assignRole($superAdminRole); // Assign role to user

        UserModel::create([
            'user_nmlengkap' => 'Administrator',
            'user_nama' => 'admin',
            'user_email' => 'admin@gmail.com',
            'user_foto' => 'undraw_profile.svg',
            'user_password' => Hash::make('12345678'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ])->assignRole($adminRole); // Assign role to user

        UserModel::create([
            'user_nmlengkap' => 'Operator',
            'user_nama' => 'operator',
            'user_email' => 'operator@gmail.com',
            'user_foto' => 'undraw_profile.svg',
            'user_password' => Hash::make('12345678'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ])->assignRole($operatorRole); // Assign role to user
    }
}
