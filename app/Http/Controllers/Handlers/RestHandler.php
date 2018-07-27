<?php namespace App\Http\Controllers\Handlers;

use RestMethod;
use App\Http\Request;
use App\Http\Controllers\Controller;
use App\Contracts\RestClientContract;

/**
 * Class RestHandler
 * @package App\Http\Controllers\Handlers
 * @license MIT
 */
class RestHandler extends Controller
{
    /**
     * RestHandler invoke
     * @param Request $request
     * @param RestClientContract $restClient
     * @return void
     */
    public function __invoke(Request $request, RestClientContract $restClient)
    {
        return RestMethod::async($request, $restClient);
    }
}