<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SaveQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    static function isSave($questionId)
    {
        $c = SaveQuestion::where('questionId', $questionId)->where('userId', Auth::id())->count();
        if ($c != 0) {
            return true;
        } else {
            return false;
        }
    }
}
