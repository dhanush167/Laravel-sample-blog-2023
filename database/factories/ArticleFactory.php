<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->text(255),
            'slug' => $this->faker->unique->slug(),
            'excerpt' => $this->faker->text(),
            'description' => $this->faker->text(),
            'status' => $this->faker->boolean(),
            'user_id' => \App\Models\User::factory(),
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
