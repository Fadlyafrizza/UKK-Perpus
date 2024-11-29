<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Judul' => fake()->sentence(),
            'Penulis' => fake()->name(),
            'Penerbit' => fake()->randomElement([
                'Gramedia',
                'Agromedia',
                'Grasindo'
            ]),
            'image' => '1732007753.jpg',
            'TahunTerbit' => fake()->dateTimeBetween('-10 years', 'now')->format('Y'),
            'created_at' => fake()->dateTimeBetween('-1 years', 'now'),
            'updated_at' => function (array $Fadly_attributes) {
                    return fake()->dateTimeBetween($Fadly_attributes['created_at'],
                );
            }
        ];
    }
}
