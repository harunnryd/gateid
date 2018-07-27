<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class RestMethodFacade
 * @package App\Facades
 * @license MIT
 */
class RestMethodFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rest-method';
    }
}