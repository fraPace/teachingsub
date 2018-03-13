<?php

namespace App\Providers;

use App\Assignment;
use App\Course;
use App\Submission;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        Route::bind('user', function ($id) {
            if(Auth::user()->hasRole('admin|professor|ta')){
                return User::withTrashed()->find($id);
            }
            else {
                return User::find($id);
            }
        });

        Route::bind('course', function ($id) {
            if(Auth::user()->hasRole('admin|professor|ta')){
                return Course::withTrashed()->find($id);
            }
            else {
                return Course::find($id);
            }
        });

        Route::bind('assignment', function ($id) {
            if(Auth::user()->hasRole('admin|professor|ta')){
                return Assignment::withTrashed()->find($id);
            }
            else {
                return Assignment::find($id);
            }
        });
        Route::bind('submission', function ($id) {
            if(Auth::user()->hasRole('admin|professor|ta')){
                return Submission::withTrashed()->find($id);
            }
            else {
                return Submission::find($id);
            }
        });
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
