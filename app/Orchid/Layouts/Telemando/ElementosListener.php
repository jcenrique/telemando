<?php

namespace App\Orchid\Layouts\Telemando;

use Orchid\Screen\Layout;
use Orchid\Screen\Layouts\Listener;

class ElementosListener extends Listener
{
    /**
     * List of field names for which values will be joined with targets' upon trigger.
     *
     * @var string[]
     */
    protected $extraVars = [];

    /**
     * List of field names for which values will be listened.
     *
     * @var string[]
     */
    protected $targets = [];

    /**
     * What screen method should be called
     * as a source for an asynchronous request.
     *
     * The name of the method must
     * begin with the prefix "async"
     *
     * @var string
     */
    protected $asyncMethod = '';

    /**
     * @return Layout[]
     */
    protected function layouts(): iterable
    {
        return [];
    }
}