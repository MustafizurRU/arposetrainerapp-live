<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }
    public function run()
    {
        //create user
        User::factory()->count(10)->create();
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


            // Create the item
            Item::factory()->create([
                'user_id' => $userId,
                'level_name' => $availableLevels[array_rand($availableLevels)],
                'level_wise_score' => rand(0, 100),
                'level_performance' => ['poor', 'fair', 'moderate', 'good', 'excellent'][rand(0, 4)],
                'pose_image_url' => rand(0, 1) ? $this->faker->imageUrl() : $this->faker->text(200)
            ]);

        }
    }
}
