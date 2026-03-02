<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $userRole  = Role::firstOrCreate(['name' => 'User']);

        $adminRole->syncPermissions(Permission::all());

        $userRole->syncPermissions([
            'transaction.view',
            'transaction.create',
            'dashboard.view',
            'archive.view',
            'transaction.update',
            'transaction.delete',
        ]);
    }
}
