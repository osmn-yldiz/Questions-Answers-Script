<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birthdate',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static function getName($id)
    {
        $x = User::where('id', $id)->get();
        return $x[0]['first_name'] . " " . $x[0]['last_name'];
    }

    static function getPhoto($id)
    {
        $w = User::where('id', $id)->get();
        if ($w[0]['photo'] != "") {
            return asset($w[0]['photo']);
        } else {
            return "http://bootdey.com/img/Content/avatar/avatar7.png";
        }
    }

}
