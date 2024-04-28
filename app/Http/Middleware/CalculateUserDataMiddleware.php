<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\DB;

class CalculateUserDataMiddleware
{
    public function handle($request, Closure $next)
    {
        // Call your function to calculate user data
        $this->calculateUserData();
        dd($this->calculateUserData());

        return $next($request);
    }

    public function calculateUserData()
    {
        // Get all users
        $users = User::all();
        // Iterate through each user
        foreach ($users as $user) {
            // Calculate total score based on the sum of level_wise_score from items table
            $totalScore = $user->items()->sum('level_wise_score');

            // Calculate overall performance based on average of level_performance from items table
            $totalItems = $user->items()->count();
            $averagePerformance = $totalItems > 0 ? $user->items()->avg(DB::raw('CASE WHEN level_performance = "poor" THEN 1 WHEN level_performance = "fair" THEN 2 WHEN level_performance = "moderate" THEN 3 WHEN level_performance = "good" THEN 4 ELSE 5 END')) : 1;
            $overallPerformance = $averagePerformance <= 1.5 ? 'poor' : ($averagePerformance <= 2.5 ? 'fair' : ($averagePerformance <= 3.5 ? 'moderate' : ($averagePerformance <= 4.5 ? 'good' : 'excellent')));

            // Update user's total_score, overall_performance, and current_level based on calculated values
            $user->total_score = $totalScore;
            $user->overall_performance = $overallPerformance;

            // Determine current_level based on highest level played
            $highestLevelPlayed = $user->items()->max('level_name');

            if ($highestLevelPlayed === 'level5') {
                $user->current_level = 'level5';
            } elseif ($highestLevelPlayed === 'level4') {
                $user->current_level = 'level4';
            } elseif ($highestLevelPlayed === 'level3') {
                $user->current_level = 'level3';
            } elseif ($highestLevelPlayed === 'level2') {
                $user->current_level = 'level2';
            } else {
                $user->current_level = 'level1';
            }
            // Save the updated user data
            $user->save();
        }
        return $users;

    }
}
