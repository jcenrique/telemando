<?php

namespace App\Orchid\Presenters;

use App\Models\Elemento;
use App\Models\Equipo;
use App\Models\Ubicacion;
use Orchid\Screen\Contracts\Cardable;
use Orchid\Screen\Contracts\Searchable;
use Orchid\Support\Presenter;
use Orchid\Support\Color;

class AlarmaPresenter extends Presenter implements Searchable, Cardable
{
    /**
     * The number of models to return for show compact search result.
     * @return int
     */
    public function perSearchShow(): int
    {
        return 5;
    }

    /**
     *
     * @param null|string $query
     * @return \Laravel\Scout\Builder
     */
    public function searchQuery(string $query = null): \Laravel\Scout\Builder
    {

        return $this->entity->search($query);
    }

    /**
     * @return string
     */
    public function label(): string
    {

        return 'Alarmas';
    }

    /**
     * @return string
     */
    public function title(): string
    {
        $elemento = Elemento::find($this->entity->elemento_id);
        $ubicacion = Ubicacion::find($elemento->ubicacion_id);
        $equipo = Equipo::find($elemento->equipo_id);

        return  $ubicacion->ubicacion . ' -> ' . $equipo->equipo . ' -> ' . $elemento->elemento ;
    }

    /**
     * @return string
     */
    public function subTitle(): string
    {

        return $this->entity->alarma;
    }

    /**
     * @return string
     */
    public function url(): string
    {
        return url('/');
    }

    /**
     * @return string
     */
    public function image(): ?string
    {
        return null;
    }
    public function color(): ?Color
    {
        return  Color::SUCCESS();
    }

	/**
	 * @return string
	 */
	public function description(): string {
        return '<strong>' . __('Consecuencia') .': </strong><p>' . $this->entity->consecuencia . '</p><strong>' . __('Actuación') .': </strong><p>'  . $this->entity->actuacion .'</p>';
	}
}
