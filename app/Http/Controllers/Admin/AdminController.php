<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //check if user is super admin
        if (Auth::user()->role == 'superadmin') {
            $users_data = $this->calculateUserData();
            $levelUser =$this->levelwiseuser();
            return view('admin.dashboard.home', compact('users_data', 'levelUser'));
        }else{
            $user = User::with('items')->find(Auth::id());
            return view('admin.useronly.userinfo', compact('user'));
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function alluser()
    {
        $users_data = User::with('items')->paginate(10);
        return view('admin.dashboard.users', compact( 'users_data'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search_string');
        $users_data = User::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('current_level', 'like', '%' . $search . '%')
            ->orWhere('overall_performance', 'like', '%' . $search . '%')
            ->orWhere('total_score', 'like', '%' . $search . '%');
            })->with('items')->paginate(10);
        return view('admin.dashboard.users', compact('search','users_data'));
    }

    public function levelwiseuser()
    {
        $users = User::all();
        $countUser = ['poor' => 0, 'fair' => 0, 'moderate' => 0, 'good' => 0, 'excellent' => 0];
        //count overall_performance of each user
        foreach ($users as $user) {
            $countUser[$user->overall_performance]++;
        }
        return $countUser;
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
