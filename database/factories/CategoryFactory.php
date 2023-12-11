<?php

namespace Database\Factories;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);
        $text_color = ['gray', 'red', 'yellow', 'green', 'blue', 'indigo', 'purple', 'pink'];
        $bg_color = ['gray', 'red', 'yellow', 'green', 'blue', 'indigo', 'purple', 'pink'];
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'text_color' => Arr::random($text_color),
            'bg_color' => Arr::random($bg_color),
        ];
    }
}
