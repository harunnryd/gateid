<?php namespace App\Providers;

use Gateway;
use App\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\Handlers\RestHandler;

/**
 * Class RouteServiceProvider
 * @package App\Providers
 * @license MIT
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->initialize()
             ->customRequest()
             ->registerMacro();
    }

    /**
     * @return $this
     */
    protected function initialize()
    {
        foreach(Gateway::routes() as $route) {
            $this->app->router->{strtolower($route->method)}($route->path, [
                'as'          => $route->path,
                'routeMethod' => $route->method,
                'middleware'  => $route->middleware,
                'uses'        => RestHandler::class
            ]);
        }

        return $this;
    }

    /**
     * @link https://laracasts.com/discuss/channels/lumen/extending-request-class
     * @return $this
     */
    protected function customRequest()
    {
        $this->app->singleton(Request::class, function ($app) {
            return $this->prepareRequest(Request::capture());
        });

        $this->app->alias(Request::class, 'request');

        return $this;
    }

    /**
     * @link https://stackoverflow.com/questions/46935874/having-trouble-rebinding-request-setuserresolver
     * @param Request $request
     * @return void
     */
    protected function prepareRequest(Request $request)
    {
        # rebinding request (user and route)
        $request->setUserResolver(function () {
            return $this->app->make('auth')->user();
        })->setRouteResolver(function () {
            return $this->app->currentRoute;
        });

        return $request;
    }

    /**
     * @return $this
     */
    public function registerMacro()
    {
        Collection::macro('batches', function (Request $request) {
            $actions = collect($request->getCurrentRoute()->actions);
            $batchs  = $actions->groupBy(function ($item, $key) {
                return isset($item->sequence) ? $item->sequence : 0;
            })->sortBy(function ($batch, $key) {
                return intval($key);
            });

            return $batchs;
        });

        return $this;
    }
}