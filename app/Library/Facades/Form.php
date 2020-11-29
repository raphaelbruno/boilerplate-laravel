<?php
namespace App\Library\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Library\Builders\FormBuilder
 */
class Form extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'form';
    }
}
