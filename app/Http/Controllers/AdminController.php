<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\UploadAdminFileRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('admin.home')->with('roles', Role::all('name'));
    }

    public function uploadUsers(UploadAdminFileRequest $request){
        $path = $request->file('file')->getRealPath();

        $reader = Excel::load($path, function($reader) {})->get();

        $records = 0;
        foreach ($reader as $row){
            $data['username'] = $row->username;
            $data['name'] = $row->name;
            $data['email'] = $row->email;
            $data['password'] = $row->password;
            $data['password_confirmation'] = $row->password;
            $data['role'] = $row->role ?: 'student';

            $validator = Validator::make( $data , User::rules() + [
                    'role' => Rule::in(['professor', 'student', 'ta'])
                ] );
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator, 'users')
                    ->with('status-danger', 'Operation Failed!')
                    ->withInput($data);
            }

            $data['password'] = Hash::make($data['password']);
            $records += DB::transaction(function() use($data){
                $user = User::create($data);
                $user->assignRole($data['role']);
                return 1;
            });
        }

        return redirect()->back()->with('status-success', 'Operation Successful! Loaded '.$records.' records.');
    }

    //TODO: Test-me if needed
    public function uploadCourses(UploadAdminFileRequest $request){
        $path = $request->file('file')->getRealPath();

        $reader = Excel::load($path, function($reader) {})->get();

        $records = 0;
        foreach ($reader as $row){
            $data['name'] = $row->name;
            $data['tag'] = $row->tag;
            $data['starts_at'] = Carbon::parse($row->starts_at)->toDateTimeString();
            $data['ends_at'] = Carbon::parse($row->ends_at)->toDateTimeString();
            $data['url'] = $row->url;
            $data['user_id'] = [];
            foreach (explode(" ", $row->usernames) as $username){
                $user = User::where('username', $username)->get();
                if(isset($user))
                    array_push($data['user_id'], $user->id);
            }

            $validator = Validator::make( $data , Course::rules());
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator, 'courses')
                    ->with('status-danger', 'Operation Failed!')
                    ->withInput($data);
            }

            $records += DB::transaction(function() use($data){
                $course = Course::create($data);
                $course->users()->attach($data['user_ids']);
                return 1;
            });
        }

        return redirect()->back()->with('status-success', 'Operation Successful! Loaded '.$records.' records.');
    }

}
