<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-user',
            'edit-user',
            'delete-user',
            'show-user',
            'create-role',
            'edit-role',
            'delete-role',
            'show-role',
            'create-permission',
            'edit-permission',
            'delete-permission',
            'show-permission',
            'create-items',
            'edit-items',
            'delete-items',
            'show-items',
            'create-laporan',
            'show-laporan',
            'download-laporan',
            'create-harga',
            'show-harga',
            'edit-harga',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }
    }
}
