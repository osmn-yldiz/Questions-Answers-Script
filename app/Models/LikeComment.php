<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    static function getCount($commentId)
    {
        return LikeComment::where('commentId', $commentId)->count();
    }
}
