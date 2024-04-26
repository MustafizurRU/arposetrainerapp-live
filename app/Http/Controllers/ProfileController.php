<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function calculateUserStats()
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
        return response()->json(['message' => 'User stats updated successfully']);
    }
}
