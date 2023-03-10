<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * @return Menu[]
     */
    public function registerMainMenu(): array
    {
        return [

            Menu::make('Inicio')

                ->icon('home')
                ->route('inicio'),

            Menu::make(__('Users'))
                ->icon('user')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access rights')),

            Menu::make(__('Roles'))
                ->icon('lock')
                ->divider()
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles'),


            Menu::make('Suministros')
                ->title('Principal')
                // ->permission('suministros')
                ->icon('fa.charging-station')
                ->route('platform.suministros'),

            Menu::make('Ubicaciones y alarmas')

                ->permission('ubicaciones')
                ->icon('fa.map-location-dot')
                ->route('platform.ubicaciones'),

            Menu::make('Inventario')

                ->permission('inventarios')
                ->icon('fa.boxes-stacked')
                ->route('platform.inventarios'),

            Menu::make('Flota')
                ->slug('sub-menu')
                ->divider()
                ->permission(['vehiculos', 'kilometros', 'repostaje'])

                ->icon('car-on')
                ->list([
                    Menu::make('Vehículos')->icon('car')->route('platform.vehiculos')->permission('vehiculos'),
                    Menu::make('Tipos vehículos')->icon('truck-monster')->route('platform.vehiculos.tipos')->permission('vehiculos'),
                    Menu::make('Marcas')->icon('copyright')->route('platform.vehiculos.marcas')->permission('vehiculos'),
                    Menu::make('Modelos')->icon('circle-info')->route('platform.vehiculos.modelos')->permission('vehiculos'),
                    Menu::make('Tecnologias')->icon('bolt')->route('platform.vehiculos.tecnologias')->permission('vehiculos'),
                    Menu::make('Detalle tecnologias')->icon('charging-station')->route('platform.vehiculos.detalles-tecnologias')->permission('vehiculos'),
                    Menu::make('Registro Kilómetros')->icon('road')->route('platform.vehiculos.kilometros')->permission('kilometros'),
                    Menu::make('Repostajes')->icon('gas-pump')->route('platform.vehiculos.repostajes')->permission('repostaje'),

                ]),







        ];
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
