<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Course;
use App\Http\Requests\AssignmentRequest;
use App\Submission;
use Carbon\Carbon;
use Chumper\Zipper\Facades\Zipper;
use Illuminate\Http\Request;

use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
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
            'only' => ['destroy', 'index', 'forceDestroy', 'restore']
        ]);
        $this->middleware('role:admin|professor|ta', [
            'except' => ['show', 'download']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $logged_user = Auth::user();
//
//        if($logged_user->hasRole('admin')){
//            $assignments = Assignment::withTrashed()->get();
//        }else {
//            $assignments = $logged_user->courses->assignemnt;
//        }
//
//        return view('assignments.index')->with(compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Course $course
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course)
    {
//        $assignment = new Assignment();
//        $assignment->course = $course;
//
//        return view('assignments.create')->with(
//            compact('assignment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AssignmentRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssignmentRequest $request)
    {
        $starts_at = $this->setStartOfTheDay($request->input('starts_at'));
        $ends_at = $this->setEndOfTheDay($request->input('ends_at'));
        $assignment = Assignment::create([
            'name' => $request->input('name'),
            'starts_at' => $starts_at->toDateTimeString(),
            'ends_at' => $ends_at->toDateTimeString(),
            'course_id' => $request->input('course_id'),
            'url' => $request->input('url'),
            'tag' => $request->input('tag')
        ]);

//        return redirect()->route('assignments.index');
        return redirect()->route('courses.show', ['id' => $assignment->course->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function show(Assignment $assignment)
    {
        $logged_user = Auth::user();
        if($logged_user->hasRole('admin')){
            $assignment->submissions = $assignment->submissions()->withTrashed()->get();
        }

        // Load only the submissions for the logged user is it is a student, otherwise get all
        if($logged_user->hasRole('student')){
            $assignment->submissions = $logged_user->submissions()->where('assignment_id', $assignment->id)->get();
            // Here we check if the user has already a submission for this assignment
            $allow_new_submission = 0 === count($assignment->submissions);

            $users = array();
        }else{
            // Here we check if the user has already a submission for this assignment
//            $allow_new_submission = 0 === $logged_user->submissions()->where('assignment_id', $assignment->id)->count();
            $allow_new_submission = true;

            $users = $assignment->course->users;
        }

        $submission = new Submission();
        $submission->assignment = $assignment;

        return view('assignments.show')->with(compact(
            'assignment', 'allow_new_submission', 'logged_user', 'submission', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assignment $assignment)
    {
//        return view('assignments.edit')->with(
//            compact('assignment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AssignmentRequest $request
     * @param  \App\Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function update(AssignmentRequest $request, Assignment $assignment)
    {
        $starts_at = $this->setStartOfTheDay($request->input('starts_at'));
        $ends_at = $this->setEndOfTheDay($request->input('ends_at'));

        $input = $request->all();
        $input['starts_at'] = $starts_at->toDateTimeString();
        $input['ends_at'] = $ends_at->toDateTimeString();

        $assignment->update($input);
        return redirect()->route('courses.show', ["id" => $assignment->course->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assignment  $assignment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assignment $assignment)
    {
        try {
            $assignment->delete();
        } catch (\Exception $e) {
        }
        return redirect()->back();
    }

    /**
     * Force remove the specified resource from storage if it was trashed already, otherwise trash it.
     *
     * @param Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(Assignment $assignment)
    {
        try {
            if($assignment->trashed())
                $assignment->forceDelete();
            else
                $assignment->delete();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }

    /**
     * Restore the specified resource.
     *
     * @param Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function restore(Assignment $assignment)
    {
        try {
            $assignment->restore();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }

    public function download(Assignment $assignment){
        $zip_file_name = $assignment->tag.'.zip';

        $files = [];
//        foreach (Storage::files($assignment->id) as $file_path) {
//            array_push($files, $this->getStorageRealPath($file_path));
//        }
        foreach ($assignment->submissions as $submission) {
            array_push($files, $this->getStorageRealPath($submission->path));
        }

        if(count($files) > 0){
            Zipper::make( $this->getStorageRealPath($zip_file_name) )->add($files)->close();

            return response()->download($this->getStorageRealPath($zip_file_name))->deleteFileAfterSend(true);
        }

        return redirect()->back()->with("status-warning", __("No files to download!"));
    }
}
