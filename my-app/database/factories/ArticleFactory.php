<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $name = $this->faker->sentence(4);

        return [
            'name'          => $name,
            'slug'          => Str::slug($name),
            'short_desc'    => $this->faker->paragraph(1),
            'full_text'     => $this->faker->paragraphs(3, true),
            'preview_image' => $this->faker->randomElement(['preview.jpg', 'preview_2.jpg']),
            'full_image'    => $this->faker->randomElement(['full.jpeg', 'full_2.jpeg']),
            'published_at'  => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
        ];
    }
}
