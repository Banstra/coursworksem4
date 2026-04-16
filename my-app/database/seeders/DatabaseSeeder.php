<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём 20 тестовых статей через фабрику
        Article::factory(20)->create();

        $this->command->info('Сидер завершён: создано 20 статей');
    }
}
