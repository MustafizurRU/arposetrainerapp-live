<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
    // Define a method to create a superadmin user
    public function superadmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Md Mustafizur Rahman', // Change this name if needed
            'email' => 'mustafizur.cd@gmail.com', // Change this email if needed
            'password' => Hash::make('secret'), // Change this password if needed
            'role' => 'superadmin', // Assuming your user model has a 'role' attribute
        ]);
    }
}
