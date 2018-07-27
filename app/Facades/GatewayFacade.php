<?php namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class GatewayFacade
 * @package App\Facades
 * @license MIT
 */
class GatewayFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'gateway';
    }
}