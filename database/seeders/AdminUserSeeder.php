<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Получаем данные из ENV, задайте их в .env файле (пример ниже)
        $adminEmail    = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');
        $adminName     = env('ADMIN_NAME');

        // Создаем роль admin, если ее еще нет
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Проверяем, существует ли админ с данным email
        $admin = User::where('email', $adminEmail)->first();

        if (!$admin) {
            $admin = User::create(
                [
                    'name'     => $adminName,
                    'email'    => $adminEmail,
                    'password' => Hash::make($adminPassword),
                ],
            );
            $this->command->info("Admin user created successfully: {$adminEmail}");
        } else {
            $this->command->info("Admin user already exists: {$adminEmail}");
        }

        $admin->assignRole($adminRole);
    }
}
