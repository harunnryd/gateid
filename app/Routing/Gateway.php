<?php namespace App\Routing;

use App\Contracts\GatewayContract;
use Illuminate\Support\Facades\Storage;

/**
 * Class Gateway
 * @package App\Routing
 * @license MIT
 */
class Gateway implements GatewayContract
{
    /**
     * @return array
     */
    public function decode()
    {
        return json_decode(Storage::disk('local')->get('routes.json'), true);
    }

    /**
     * @return object
     */
    public function encode()
    {
        return json_decode(Storage::disk('local')->get('routes.json'), false);
    }

    /**
     * @param string $param
     * @return integer
     */
    public function count(string $param = '')
    {
        $param = !empty($param) ? $param : 'routes';
        return count($this->decode()[$param]);
    }

    /**
     * @param boolean $bool
     * @return object|array
     */
    public function routes(bool $bool = false)
    {
        return $bool
                ? $this->decode()['routes']
                : $this->encode()->routes;
    }

}