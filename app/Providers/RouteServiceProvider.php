<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {
    protected $namespace          = 'App\Http\Controllers';
    protected $nameSpaceAdmin     = 'App\Http\Controllers\Backend';
    protected $nameSpaceSiteAdmin = 'App\Http\Controllers\Frontend';

    public function boot() {
        parent::boot();
    }

    public function map() {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapSiteAdminRoutes();
    }

    protected function mapApiRoutes() {
        Route::prefix( 'api' )
            ->middleware( 'api' )
            ->namespace( $this->namespace )
            ->group( base_path( 'routes/api.php' ) );
    }

    protected function mapWebRoutes() {
        Route::middleware( 'web' )
            ->namespace( $this->namespace )
            ->group( base_path( 'routes/web.php' ) );
    }

    protected function mapAdminRoutes() {
        Route::middleware( ['web', 'auth', 'permission'] )->name( 'admin.' )
            ->namespace( $this->nameSpaceAdmin )
            ->group( base_path( 'routes/admin.php' ) );
    }

    protected function mapSiteAdminRoutes() {
        Route::middleware( ['web', 'auth', 'permission'] )->name( 'admin.' )
            ->namespace( $this->nameSpaceSiteAdmin )
            ->group( base_path( 'routes/site_admin.php' ) );
    }

}
