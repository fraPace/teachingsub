<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Course;
use App\Http\Requests\CourseRequest;
use App\Submission;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin', [
            'only' => ['destroy', 'forceDestroy', 'restore']
        ]);
        $this->middleware('role:admin|professor|ta', [
            'except' => ['index', 'show']
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logged_user = Auth::user();
        $users = [];
        if($logged_user->hasRole('admin'))
            $users['Professors'] = User::role('professor')->get();
        if($logged_user->hasRole('admin|professor'))
            $users['TAs'] = User::role('ta')->get();
        if($logged_user->hasRole('admin|professor|ta'))
            $users['Students'] = User::role('student')->get();

        $course = new Course();

        if($logged_user->hasRole('admin')){
            $courses = Course::withTrashed()->get();
        } else if ($logged_user->hasRole('professor|ta')){
            $courses = $logged_user->courses;
        } else {
            $courses = $logged_user->courses()->where('starts_at', '<=', Carbon::now())->get();
        }

        foreach ($courses as $c){
            $c->usersById = $c->users->keyBy('id')->toArray();
        }

        return view('courses.index')->with(compact('courses','users', 'logged_user', 'course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        $starts_at = $this->setStartOfTheDay($request->input('starts_at'));
        $ends_at = $this->setEndOfTheDay($request->input('ends_at'));

        $course = Course::create([
            'name' => $request->input('name'),
            'starts_at' => $starts_at->toDateTimeString(),
            'ends_at' => $ends_at->toDateTimeString(),
            'url' => $request->input('url'),
            'tag' => $request->input('tag')
        ]);
        $course->users()->attach($request->input('user_id'));

        return redirect()->route('courses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->users = $course->users->filter(function ($user, $key) {
            return !$user->hasRole('admin');
        });
        $course->usersById = $course->users->keyBy('id')->toArray();

        $logged_user = Auth::user();
        $users = [];
        if($logged_user->hasRole('admin'))
            $users['Professors'] = User::role('professor')->get();
        if($logged_user->hasRole('admin|professor'))
            $users['TAs'] = User::role('ta')->get();
        if($logged_user->hasRole('admin|professor|ta'))
            $users['Students'] = User::role('student')->get();

        if($logged_user->hasRole('admin|professor|ta'))
            $course->assignments = $course->assignments()->withTrashed()->get();
        else
            $course->assignments = $course->assignments()->where('starts_at', '<=', Carbon::now())->get();

        $assignment = new Assignment();
        $assignment->course = $course;
        $submission = new Submission();
        $submission->assignment = $assignment;

        $allow_new_submission = [];
        foreach ($course->assignments as $ass){
            // Load only the submissions for the logged user is it is a student, otherwise get all
            if($logged_user->hasRole('student')){
                $assignment->submissions = $logged_user->submissions()->where('assignment_id', $assignment->id)->get();
                // Here we check if the user has already a submission for this assignment
                $allow_new_submission[$ass->id] = 0 === count($assignment->submissions);
            }else{
                // Here we check if the user has already a submission for this assignment
                $allow_new_submission[$ass->id] = 0 === $logged_user->submissions()->where('assignment_id', $assignment->id)->count();
            }
        }

        return view('courses.show')->with(compact(
            'course', 'logged_user', 'users', 'assignment', 'submission', '$allow_new_submission'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseRequest $request
     * @param  \App\Course $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CourseRequest $request, Course $course)
    {
        $starts_at = $this->setStartOfTheDay($request->input('starts_at'));
        $ends_at = $this->setEndOfTheDay($request->input('ends_at'));

        $input = $request->all();
        $input['starts_at'] = $starts_at->toDateTimeString();
        $input['ends_at'] = $ends_at->toDateTimeString();

        $course->update($input);
        $course->users()->sync($request->input('user_id'));

        return redirect()->route('courses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }

    /**
     * Force remove the specified resource from storage if it was trashed already, otherwise trash it.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(Course $course)
    {
        try {
            if($course->trashed())
                $course->forceDelete();
            else
                $course->delete();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }

    /**
     * Restore the specified resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function restore(Course $course)
    {
        try {
            $course->restore();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }
}
