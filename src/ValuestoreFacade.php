<?php

namespace Spatie\Valuestore;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Spatie\Valuestore\ValuestoreClass
 */
class ValuestoreFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'valuestore';
    }
}
