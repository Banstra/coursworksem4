<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём роли
        $moderator = Role::create(['name' => 'moderator', 'label' => 'Модератор']);
        $reader = Role::create(['name' => 'reader', 'label' => 'Читатель']);

        // Находим или создаём тестового модератора
        $modUser = User::firstOrCreate(
            ['email' => 'moderator@example.com'],
            [
                'name' => 'Главный Модератор',
                'password' => Hash::make('moderator123'),
                'role_id' => $moderator->id,
            ]
        );

        // Если пользователь уже существовал, обновляем роль
        $modUser->update(['role_id' => $moderator->id]);

        $this->command->info(" Роли созданы. Модератор: moderator@example.com / moderator123");
    }
}
