<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();
    }

    public function map()
    {
        $this->mapApiRoutes();
        if (config("app.have_website")) {
            $this->mapWebRoutes();
        } else {
            $this->mapFrontNeeded();
        }
       
        $this->mapDashboardRoutes();
        $this->mapDashboardVendorRoutes();
    }

    protected function mapDashboardVendorRoutes()
    {
    }

    protected function mapFrontNeeded()
    {
    }
}
