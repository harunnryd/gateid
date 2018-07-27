<?php namespace App\Http;

use Gateway;
use Illuminate\Http\Request as BaseRequest;

/**
 * Class Request
 * @package App\Http
 * @link https://stackoverflow.com/questions/30577949/can-i-get-current-route-information-in-middleware-with-lumen
 * @link https://github.com/laravel/framework/pull/9417#issuecomment-115736245
 * @license MIT
 */
class Request extends BaseRequest
{

    /**
     * @return array
     */
    public function getRouteRaw()
    {
        $route = call_user_func($this->getRouteResolver());

        return $route
                ? $route[1]
                : [];
    }

    /**
     * @param string|null $param
     * @return Illuminate\Routing\Route|object|string
     */
    public function route($param = null)
    {
        $route = call_user_func($this->getRouteResolver());

        return is_null($route) || is_null($param)
                ? $route
                : $route[2][$param];
    }

    /**
     * @return array
     */
    public function getRouteParams()
    {
        $route = call_user_func($this->getRouteResolver());

        return $route 
                ? $route[2] 
                : [];
    }

    /**
     * @return string
     */
    public function getCurrentPath()
    {
        return $this->getRouteRaw()['as'];
    }

    public function getCurrentMethod()
    {
        return $this->getRouteRaw()['routeMethod'];
    }

    /**
     * @return array|object
     */
    public function getCurrentRoute(bool $bool = false)
    {
        return collect(Gateway::routes($bool))->where('path', '=', $this->getCurrentPath())->where('method', '=', $this->getCurrentMethod())->first();
    }

    /**
     * @param boolean $bool
     * @return array|object
     */
    public function getParseIncludes(bool $bool = false)
    {
        return $bool
                ? $this->getCurrentRoute($bool)['parseIncludes']
                : $this->getCurrentRoute()->parseIncludes;
    }

    /**
     * @return boolean
     */
    public function isParseIncludes()
    {
        return isset($this->getCurrentRoute(true)['parseIncludes']);
    }
}