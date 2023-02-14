<?php

namespace App\Providers;

use App\Models\Alarma;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Icons\IconFinder;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
       

        $dashboard->registerSearch([
            Alarma::class,
            //...Models
          ]);

          Builder::macro('search', function ($field, $string) {
            return $string ? $this->where($field, 'like', '%' . $string . '%') : $this;
        });
       
    }
}
