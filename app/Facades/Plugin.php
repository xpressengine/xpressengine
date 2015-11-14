<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Plugin extends Facade
{
    const STATUS_ACTIVATED = 'activated';
    const STATUS_DEACTIVATED = 'deactivated';
    const STATUS_INSTALLED = 'installed';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.plugin';
    }
}
