<?php

namespace App\Models;

use App\Helper\mHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $guarded = [];

    static function getCount($questionId)
    {
        return Comments::where('questionId', $questionId)->count();
    }

    static function isCorrectVariable($questionId)
    {
        return Comments::where('questionId', $questionId)->where('isCorrect', 1)->count();
    }

    static function getLastComment($questionId)
    {
        if (self::getCount($questionId)) {
            $data = Comments::where('questionId', $questionId)->orderBy('id', 'desc')->limit(1)->get();
            return User::getName($data[0]['userId']) . " tarafından " . mHelper::time_ago($data[0]['created_at']) . " yazıldı.";
        } else {
            return "";
        }
    }
}
