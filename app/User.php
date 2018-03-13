<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function rules(){
        return [
            'username' => 'required|string|max:255|unique:users,username',
            'name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users',
            'email' => 'present|nullable|string|email|max:255',
            'password' => 'required|string|min:6|confirmed'
        ];
    }

    public static function updateRules(){
        return [
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'present|nullable|string|email|max:255',
        ];
    }

    /**
     * The courses that belong to the user.
     */
    public function courses()
    {
        return $this->belongsToMany('App\Course');
    }

    /**
     * The submissions that belong to the user.
     */
    public function submissions()
    {
        return $this->hasMany('App\Submission');
    }

}
