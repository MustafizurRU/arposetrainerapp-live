<?php

namespace Database\Factories;

use App\Models\Item;
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
        // Define the number of items you want to create
        $numberOfItems = 50; // Change this to the desired number of items
        // Loop to create items
        for ($i = 0; $i < $numberOfItems; $i++) {
            // Get a random user ID
            $userId = User::all()->random()->id;

            // Check if the user already has an item with the same level
            $existingLevels = Item::where('user_id', $userId)->pluck('level_name')->toArray();
            $availableLevels = array_diff(['level1', 'level2', 'level3', 'level4', 'level5'], $existingLevels);

            if (empty($availableLevels)) {
                // If the user already has items for all levels, skip creating a new item
                continue;
            }
        }
        return [
            'user_id' => $userId,
            'level_name' => $availableLevels[array_rand($availableLevels)],
            'level_wise_score' => rand(0, 100),
            'level_performance' => ['poor', 'fair', 'moderate', 'good', 'excellent'][rand(0, 4)],
            'pose_image_url' => fake()->imageUrl(640, 480, 'people', true, 'pose')
        ];
    }
}
