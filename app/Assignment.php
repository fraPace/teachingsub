<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'starts_at', 'ends_at', 'course_id', 'url', 'tag'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'starts_at',
        'ends_at',
        'deleted_at',
        'created_at',
        'updated_at'
    ];


    public static function rules(){
        return [
            'name' => 'required|string|max:255',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after:starts_at',
            'course_id' => 'required|exists:courses,id',
            'tag' => 'required|string|max:5'
        ];
    }

    /**
     * Get the course that owns the assignment.
     */
    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    /**
     * The submissions that belong to the assignment.
     */
    public function submissions()
    {
        return $this->hasMany('App\Submission');
    }

    public function startsAt(){
        if(isset($this->starts_at))
            return $this->starts_at->toDateString();
        return "";
    }

    public function endsAt(){
        if(isset($this->ends_at))
            return $this->ends_at->toDateString();
        return "";
    }
}
