<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Successfully!',
                    'token' => $token
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);

        }
    }
    //register
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully',
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    //items
    public function allItems()
    {
        try {
            $items = User::with('items')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Items retrieved successfully',
                'data' => $items
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    //post items
    public function createItem(Request $request)
    {
        try {
            $request->validate([
                'level_name' => 'required',
                'level_wise_score' => 'required',
                'level_performance' => 'required',
                'pose_image_url' => 'required'
            ]);
            $item = new Item();
            $item->user_id = Auth::id();
            $item->level_name = $request->level_name;
            $item->level_wise_score = $request->level_wise_score;
            $item->level_performance = $request->level_performance;
            $item->pose_image_url = $request->pose_image_url;
            $item->save();
            // Find the user by ID
            $user = User::findOrFail(Auth::id());
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
            return response()->json([
                'status' => 'success',
                'data' => $item,
                'message' => 'Item created successfully',
                'user_details' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    //update item
    public function updateItem(Request $request, $id)
    {
        try {
            $request->validate([
                'level_name' => 'required',
                'level_wise_score' => 'required',
                'level_performance' => 'required',
                'pose_image_url' => 'required'
            ]);
            $item = Item::findOrFail($id);

            $item->level_name = $request->level_name;
            $item->level_wise_score = $request->level_wise_score;
            $item->level_performance = $request->level_performance;
            $item->pose_image_url = $request->pose_image_url;
            $item->save();
            // Find the user by ID
            $user = User::findOrFail(Auth::id());
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
            return response()->json([
                'status' => 'success',
                'data' => $item,
                'message' => 'Item updated successfully',
                'user_details' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    //level wise user score, overall performance, image url
    public function levelWiseUserData(Request $request)
    {
        try {
            $user = User::findOrFail(Auth::id());
            $level = $request->level;
            $levelWiseData = $user->items()->where('level_name', $level)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Level wise score retrieved successfully',
                'level' => $level,
                'data' => $levelWiseData
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }

// Upload an Image File to Cloudinary with One line of Code
    public function uploadImage(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'false',
                'message' => 'Please Fix the following errors',
                'error' => $validator->errors()
            ]);
        }
        $image = $request->file('image')->getRealPath();
        // Upload image to Cloudinary specific folder
        $cloudinary = Cloudinary::upload($image, [
            'folder' => 'PoseImages'
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Image uploaded successfully',
            'url' => $cloudinary->getSecurePath()
        ]);
    }
    //update image
    public function updateImage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 'false',
                'message' => 'Please Fix the following errors',
                'error' => $validator->errors()
            ]);
        }
        $item = Item::findOrFail($id);
        $image = $request->file('image')->getRealPath();
        // Upload image to Cloudinary specific folder
        $cloudinary = Cloudinary::upload($image, [
            'folder' => 'PoseImages'
        ]);
        $item->pose_image_url = $cloudinary->getSecurePath();
        $item->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Image updated successfully',
            'url' => $cloudinary->getSecurePath()
        ]);
    }
}
