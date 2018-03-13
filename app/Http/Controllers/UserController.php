<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
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
            'except' => ['edit', 'update', 'updatePassword']
        ]);
        $this->middleware('role:admin|professor|ta', [
            'only' => ['edit', 'update', 'updatePassword']
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
        if($logged_user->hasRole('admin'))
            $users = User::withTrashed()->get();
        else
            $users = User::all();
        $user = new User();
        $roles = Role::all();
        return view('users.index')->with(compact('users','user', 'roles'));
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
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        if($request->has('password'))
            $data['password'] = Hash::make($request->input('password'));
        $user = User::create($data);
        $user->assignRole($request->input('role') ?: 'student');

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = Role::all();
        return view('users.show')->with(compact('user', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit')->with(compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->all();
        if($request->has('password'))
            unset($data['password']);
        $user->update($data);

        $logged_user = Auth::user();
        if($logged_user->hasRole('admin')){
            $user->syncRoles($request->input('role') ?: 'student');
        }

        return redirect()->back()->with('status-success', __("Modification Saved!"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }

    /**
     * Force remove the specified resource from storage if it was trashed already, otherwise trash it.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function forceDestroy(User $user)
    {
        try {
            if($user->trashed())
                $user->forceDelete();
            else
                $user->delete();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }

    /**
     * Restore the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function restore(User $user)
    {
        try {
            $user->restore();
        } catch (\Exception $e) {
        }

        return redirect()->back();
    }

    public function updatePassword(PasswordRequest $request)
    {

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords does not matches
            $message = __("Your current password does not matches with the password you provided. Please try again.");
            return redirect()->back()->withInput()->withErrors(['current-password' => $message]);
        }

        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect()->back()->with("status-success", __("Password changed successfully!"));
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect()->back()->with("status-success", __("Password changed successfully !"));
    }
}
