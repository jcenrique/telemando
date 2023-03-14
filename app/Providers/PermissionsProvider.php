<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;

class PermissionsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        $permissions = ItemPermission::group(__('Recursos'))
        ->addPermission('equipos', __('Acceso a equipos'))
        ->addPermission('zonas', __('Acceso a las zonas'));

        $dashboard->registerPermissions($permissions);

        $permissions=ItemPermission::group(__('Ubicaciones'))
            ->addPermission('ubicaciones', __('Acceso a las ubicaciones'));
            $dashboard->registerPermissions($permissions);

            $permissions=ItemPermission::group(__('Flota'))
            ->addPermission('flota', __('Acceso a todos los elementos de la flota'))
            ->addPermission('vehiculos', __('Acceso a los vehiculos'))
            ->addPermission('kilometros', __('Acceso a los kilometros'))
            ->addPermission('repostaje', __('Acceso a los repostajes'));
            $dashboard->registerPermissions($permissions);

            $permissions=ItemPermission::group(__('Inventarios'))
            ->addPermission('inventarios', __('Acceso a los inventarios'));
            $dashboard->registerPermissions($permissions);

    }
    
}
