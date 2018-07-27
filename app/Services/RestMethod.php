<?php namespace App\Services;

use Gateway;
use App\Http\Request;
use GuzzleHttp\Promise;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Contracts\RestClientContract;

/**
 * Class RestMethod
 * @package App\Services
 * @license MIT
 */
class RestMethod
{
    /**
     * @param Request $request
     * @param Collection $actions
     * @return void
     */
    public function async(Request $request, RestClientContract $client)
    {
        $parametersJar = array_merge($request->getRouteParams(), ['query_string' => $request->getQueryString()]);
        $client->setBody($request->getContent());

        $results = collect()->batches($request)->reduce(function ($carry, $batch) use ($client, &$parametersJar) {
            $responses = $this->promises($client, $batch, $parametersJar);
            $parametersJar = array_merge($parametersJar, $this->exportParameters($responses));
            return array_merge($carry, $responses);
        }, []);

        # response json
        $responses = collect($results)->map(function ($response, $key) {
            if ($response['state'] == 'fulfilled') return json_decode($response['value']->getBody(), true);
            if ($response['state'] != 'fulfilled') return json_decode($response['reason']->getResponse()->getBody(), true);
        });

        $output = [];
        $responses->each(function ($item, $key) use (&$output) {
            # set no content if item == null
            array_set($output, $key, is_null($item) ? 'gateway not resolve' : $item);
        });

        if ($request->isParseIncludes()) {
            $outputWithParseIncludes = [];

            collect($request->getParseIncludes())->each(function ($item, $key) use (&$outputWithParseIncludes, $output) {
                if ($item->relationship == 'one-to-one') {
                    collect($output[$item->from])->each(function ($data, $key) use (&$outputWithParseIncludes, $item, $output) {
                        $currentData = collect($output[$item->to])->where($item->foreignKey->to, $data[$item->foreignKey->from])->first();
        
                        if ($currentData) {
                            unset($data[$item->foreignKey->from]);
                            $data[$item->foreignKey->includeName] = $currentData;
                            array_push($outputWithParseIncludes, $data);
                        }
                    });
                }
            });
    
            return $outputWithParseIncludes;
        }   return $output;

    }

    /**
     * @param array $responses
     * @return void
     */
    protected function exportParameters(array $responses)
    {
        return collect(array_keys($responses))->reduce(function ($carry, $alias) use ($responses) {
            $output = [];

            # don't pass param if state != fulfilled
            if ($responses[$alias]['state'] != 'fulfilled') { return $carry; }

            $decoded = json_decode($responses[$alias]['value']->getBody(), true);
            
            if (!is_array($decoded)) {
                return $carry;
            }

            foreach($decoded as $key => $val) {
                $output[$alias. '%'. $key] = $val;
            }

            return array_merge($carry, $output);
        }, []);
    }

    /**
     * @param RestClientContract $client
     * @param Collection $batch
     * @param array $parametersJar
     * @return void
     */
    protected function promises(RestClientContract $client, Collection $batch, array $parametersJar)
    {
        $promises = $batch->reduce(function ($carry, $action) use ($client, &$parametersJar) {
            $carry[$action->outputKey] = $client->call($action->method. "Async", $this->resolvePath($action, $parametersJar));
            return $carry;
        });

        return Promise\settle($promises)->wait();
    }

    /**
     * @param $action
     * @param array $parametersJar
     * @return void
     */
    protected function resolvePath($action, array $parametersJar)
    {
        $url = $action->hostname; 
        if (empty($action->hostname)) {
            $domain = Gateway::encode()->global->domain;
            $subdomain = $action->service;
            $url = $subdomain. '.'. $domain;
        }

        $path = $action->path;
    
        collect($parametersJar)->each(function ($val, $key) use (&$path) {
            $path = Str::replaceFirst('{'. $key. '}', $val, $path);
        });
    
        if (array_key_exists('query_string', $parametersJar)) { $path .= '?'. $parametersJar['query_string']; }
        if ($path[0] != '/') { $path = '/'. $path; }
            
        return 'http://'. $url. $path;
    }
}