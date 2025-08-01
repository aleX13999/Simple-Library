<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Очистка кеша разрешений перед добавлением новых
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Создаем разрешения
        Permission::firstOrCreate(['name' => 'manage books']);
        Permission::firstOrCreate(['name' => 'manage authors']);
        Permission::firstOrCreate(['name' => 'manage own books']);
        Permission::firstOrCreate(['name' => 'manage own author']);

        // Создаем роли
        $adminRole  = Role::firstOrCreate(['name' => 'admin']);
        $authorRole = Role::firstOrCreate(['name' => 'author']);

        // Присваиваем разрешения ролям
        $adminRole->givePermissionTo(Permission::all());
        $authorRole->givePermissionTo(
            [
                'manage own books',
                'manage own author',
            ],
        );
    }
}
