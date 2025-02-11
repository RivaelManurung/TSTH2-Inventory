<?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;
// use Carbon\Carbon;

// class RolePermissionSeeder extends Seeder
// {
//     public function run()
//     {
//         // Define permissions based on your routes
//         $permissions = [
//             'view gudang', 'create gudang', 'update gudang', 'delete gudang',
//             'view satuan', 'create satuan', 'update satuan', 'delete satuan',
//             'view jenisbarang', 'create jenisbarang', 'update jenisbarang', 'delete jenisbarang',
//             'login', 'logout', 'register', 'refresh', 'profile'
//         ];

//         // Create permissions
//         foreach ($permissions as $perm) {
//             Permission::firstOrCreate(['name' => $perm]);
//         }

//         // Create roles (using the data you provided)
//         $roles = [
//             [
//                 'role_title' => 'Super Admin',
//                 'role_slug' => 'super-admin',
//                 'role_desc' => '-',
//                 'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//                 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
//             ],
//             [
//                 'role_title' => 'Admin',
//                 'role_slug' => 'admin',
//                 'role_desc' => '-',
//                 'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//                 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
//             ],
//             [
//                 'role_title' => 'Operator',
//                 'role_slug' => 'operator',
//                 'role_desc' => '-',
//                 'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//                 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
//             ]
//         ];

//         // Create roles
//         foreach ($roles as $roleData) {
//             $role = Role::firstOrCreate(['name' => $roleData['role_slug']]);
            
//             // Assign permissions to roles based on role slug
//             if ($role->name == 'super-admin') {
//                 // Super Admin has all permissions
//                 $role->givePermissionTo($permissions);
//             } elseif ($role->name == 'admin') {
//                 // Admin can have most permissions except login, register
//                 $adminPermissions = [
//                     'view gudang', 'create gudang', 'update gudang', 'delete gudang',
//                     'view satuan', 'create satuan', 'update satuan', 'delete satuan',
//                     'view jenisbarang', 'create jenisbarang', 'update jenisbarang', 'delete jenisbarang',
//                     'profile', 'refresh'
//                 ];
//                 $role->givePermissionTo($adminPermissions);
//             } elseif ($role->name == 'operator') {
//                 // Operator can view and create, but cannot update or delete
//                 $operatorPermissions = [
//                     'view gudang', 'view satuan', 'view jenisbarang', 'profile'
//                 ];
//                 $role->givePermissionTo($operatorPermissions);
//             }
//         }
//     }
// }

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Carbon\Carbon;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions based on route names
        $permissions = [
            // Gudang permissions
            'gudang.index', 'gudang.store', 'gudang.show', 'gudang.update', 'gudang.destroy',
            // Satuan permissions
            'satuan.show', 'satuan.store', 'satuan.update', 'satuan.destroy',
            // Jenis Barang permissions
            'jenisbarang.show', 'jenisbarang.store', 'jenisbarang.update', 'jenisbarang.destroy',
            // Role management permissions
            'roles.index', 'roles.store', 'roles.show', 'roles.update', 'roles.destroy',
            'roles.permissions.assign', 'roles.permissions.get', 'permissions.all',
            // Auth permissions
            'auth.login', 'auth.logout', 'auth.register', 'auth.refresh', 'auth.profile'
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }       

        // Create roles
        $roles = [
            [
                'role_title' => 'Super Admin',
                'role_slug' => 'super-admin',
                'role_desc' => '-',
                'permissions' => $permissions // All permissions
            ],
            [
                'role_title' => 'Admin',
                'role_slug' => 'admin',
                'role_desc' => '-',
                'permissions' => [
                    'gudang.index', 'gudang.store', 'gudang.show', 'gudang.update', 'gudang.destroy',
                    'satuan.show', 'satuan.store', 'satuan.update', 'satuan.destroy',
                    'jenisbarang.show', 'jenisbarang.store', 'jenisbarang.update', 'jenisbarang.destroy',
                    'auth.profile', 'auth.refresh'
                ]
            ],
            [
                'role_title' => 'Operator',
                'role_slug' => 'operator',
                'role_desc' => '-',
                'permissions' => [
                    'gudang.index', 'satuan.show', 'jenisbarang.show', 'auth.profile'
                ]
            ]
        ];

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate([
                'name' => $roleData['role_slug']
            ], [
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            
            // Assign permissions
            $role->syncPermissions($roleData['permissions']);
        }
    }
}