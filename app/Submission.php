<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'path', 'user_id', 'assignment_id'
    ];


    public static function rules(){
        return [
            'file' => 'required|file|mimetypes:text/html',
            'user_id' => 'required|exists:users,id',
            'assignment_id' => 'required|exists:assignments,id'
        ];
    }

    /**
     * Get the assignment that owns the submission.
     */
    public function assignment()
    {
        return $this->belongsTo('App\Assignment');
    }

    /**
     * Get the user that owns the submission.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
