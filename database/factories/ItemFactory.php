<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ItemFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'level_name' => $this->faker->randomElement(['level1', 'level2', 'level3', 'level4','level5']),
            'level_wise_score' => $this->faker->numberBetween(0, 100),
            'level_performance' => $this->faker->randomElement(['poor', 'fair', 'moderate', 'good', 'excellent']),
            'pose_image_url' => $this->faker->text(200),
        ];
    }
}
