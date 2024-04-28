<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The number of items to create.
     *
     * @var int
     */

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'level_name' => $this->faker->randomElement(['level1', 'level2', 'level3', 'level4', 'level5']),
            'level_wise_score' => $this->faker->numberBetween(0, 100),
            'level_performance' => $this->faker->randomElement(['poor', 'fair', 'moderate', 'good', 'excellent']),
            'pose_image_url' => $this->faker->imageUrl(640, 480, 'people', true, 'pose')
        ];
    }
}
