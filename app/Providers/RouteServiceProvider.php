<?php

namespace App\Providers;

use App\Person;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use App\Archive;
use App\Genre;
use App\Manga;
use App\User;
use Imtigger\LaravelJobStatus\JobStatus;

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
        Route::pattern('id', '[0-9]+');
        Route::pattern('archive_name', '.+');
        Route::pattern('sort', 'ascending|descending');
        Route::pattern('page', '[0-9]+');

        Route::bind('genre', function ($name) {
            return Genre::where('name', $name)->firstOrFail();
        });

        Route::model('archive', Archive::class);
        Route::model('user', User::class);
        Route::model('manga', Manga::class);
        Route::model('person', Person::class);
        Route::model('jobStatus', JobStatus::class);

        Route::model('notification', DatabaseNotification::class);

        parent::boot();
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
