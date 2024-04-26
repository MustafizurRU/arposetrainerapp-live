<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'level_name', 'level_wise_score', 'level_performance', 'pose_image_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
