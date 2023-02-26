<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notifications extends Model
{
    use HasFactory;

    protected $guarded = [];

    static function getIsReadCount()
    {
        return Notifications::where('receiverUserId', Auth::id())->where('isRead', 1)->count();
    }
}
