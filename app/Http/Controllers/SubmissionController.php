<?php

namespace App\Http\Controllers;

use App\Assignment;
use App\Http\Requests\SubmissionRequest;
use App\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('submission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Assignment $assignment
     * @return \Illuminate\Http\Response
     */
    public function create(Assignment $assignment)
    {
//        $logged_user = Auth::user();
//
//        // Check if the User has a submission for the given assignment
//        $submission = $logged_user->submissions()->where('assignment_id', $assignment->id)->first();
//        if(isset($submission))
//            return redirect()->route('submissions.edit', ['id' => $submission->id]);
//
//        $submission = new Submission();
//        $submission->assignment = $assignment;
//        return view('submissions.create')->with(compact('submission', 'logged_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubmissionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubmissionRequest $request)
    {
        if ($request->file('file')->isValid()) {
            $file = $request->file('file');
            $name = $request->input('name');
            $assignment_id = $request->input('assignment_id');

            Submission::create([
                'name' => $name,
                'user_id' => $request->input('user_id'),
                'assignment_id' =>$assignment_id,
                'path' => $file->storeAs($assignment_id, $name.'.'.$file->getClientOriginalExtension())
            ]);
            return redirect()->route('assignments.show', ["id" => $assignment_id]);
        }else{
            return redirect()->back()->withErrors(["file" => "Upload Failed."])->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function show(Submission $submission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function edit(Submission $submission)
    {
//        $logged_user = Auth::user();
//
//        if(!$logged_user->hasRole('admin|professor|ta')){
//            // Check if the Submission belongs to the User
//            if($submission->user_id != $logged_user->id)
//                return redirect()->route('home');
//        }
//
//        return view('submissions.edit')->with(compact('submission', 'logged_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Submission $submission)
    {

        $logged_user = Auth::user();
        if(!$logged_user->hasRole('admin')){
            // Check if the Submission belongs to the User
            if($submission->user_id != Auth::user()->id){
                return redirect()->route('home');
            }
        }

        if ($request->file('file')->isValid()) {
            Storage::delete($submission->path);

            $file = $request->file('file');
            $name = $request->input('name');
            $assignment_id = $request->input('assignment_id');

            $submission->update([
                'path' => $file->storeAs($assignment_id, $name.'.'.$file->getClientOriginalExtension())
            ]);
            return redirect()->route('assignments.show', ["id" => $assignment_id]);
        }else{
            return redirect()->back()->withErrors(["file" => "Upload Failed."])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Submission  $submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submission $submission)
    {
        try {
            $submission->delete();
        } catch (\Exception $e) {
        }
        return redirect()->back();
    }

    /**
     * Force remove the specified resource from storage if it was trashed already, otherwise trash it.
     *
     * @param Submission $submission
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(Submission $submission)
    {
        try {
            if($submission->trashed())
                $submission->forceDelete();
            else
                $submission->delete();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }

    /**
     * Restore the specified resource.
     *
     * @param Submission $submission
     * @return \Illuminate\Http\Response
     */
    public function restore(Submission $submission)
    {
        try {
            $submission->restore();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }

    public function download(Submission $submission){
        return response()->download($this->getStorageRealPath($submission->path));
    }
}
