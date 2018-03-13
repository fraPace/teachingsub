<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
//Route::get('home', 'HomeController@index')->name('home');
Route::get('home', 'CourseController@index')->name('home');

Route::prefix('admin')->group(function(){
    Route::get('/', 'AdminController@home')->name('admin.home');
    Route::post('uploadUsers', 'AdminController@uploadUsers')->name('admin.upload.users');
//    Route::post('uploadCourses', 'AdminController@uploadCourse')->name('admin.upload.courses');
});

//Auth::routes();
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');
// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::put('users/{user}/resetPassword', 'UserController@resetPassword')->name('users.resetPassword');
Route::put('users/{user}/updatePassword', 'UserController@updatePassword')->name('users.updatePassword');
Route::delete('users/{user}/force', 'UserController@forceDestroy')->name('users.destroy.force');
Route::put('users/{user}/restore', 'UserController@restore')->name('users.restore');
Route::resource('users', 'UserController', ['except' => [
    'create'
]]);

Route::delete('courses/{course}/force', 'CourseController@forceDestroy')->name('courses.destroy.force');
Route::put('courses/{course}/restore', 'CourseController@restore')->name('courses.restore');
Route::resource('courses', 'CourseController', ['except' => [
    'create', 'edit'
]]);

Route::get('assignments/create/{course}', 'AssignmentController@create')->name('assignments.create.course');
Route::get('assignments/{assignment}/download', 'AssignmentController@download')->name('assignments.download');
Route::delete('assignments/{assignment}/force', 'AssignmentController@forceDestroy')->name('assignments.destroy.force');
Route::put('assignments/{assignment}/restore', 'AssignmentController@restore')->name('assignments.restore');
Route::resource('assignments', 'AssignmentController', ['except' => [
    'index', 'create', 'edit'
]]);

Route::get('submissions/create/{assignment}', 'SubmissionController@create')->name('submissions.create.assignment');
Route::get('submissions/{submission}/download', 'SubmissionController@download')->name('submissions.download');
Route::delete('submissions/{submission}/force', 'SubmissionController@forceDestroy')->name('submissions.destroy.force');
Route::put('submissions/{submission}/restore', 'SubmissionController@restore')->name('submissions.restore');
Route::resource('submissions', 'SubmissionController', ['except' => [
    'index', 'create', 'edit', 'show'
]]);

