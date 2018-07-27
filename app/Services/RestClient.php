<?php namespace App\Services;

use App\Http\Request;
use GuzzleHttp\Client;
use App\Contracts\RestClientContract;
use GuzzleHttp\Exception\ClientException;
use App\Exceptions\GuzzleClientException;

/**
 * Class RestClient
 * @package App\Services
 * @license MIT
 */
class RestClient implements RestClientContract
{
    /**
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $guzzleParams = [
        'headers' => [],
        'timeout' => 40
    ];

    const USER_ID_ANONYMOUS = -1;

    /**
     * RestClient constructor
     * @param GuzzleHttp\Client $client
     */
    public function __construct(Client $client, Request $request)
    {
        $this->client = $client;
        $this->setHeaders([
            'X-User'        => $request->user()->id ?? self::USER_ID_ANONYMOUS,
            'X-Token-Scope' => $request->user() && !empty($request->user()->token()) ? implode(',', $request->user()->token()->scopes): '',
            'X-Client-Ip'   => $request->getClientIp(),
            'User-Agent'    => $request->header('User-Agent'),
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json'
        ]);
    }

    /**
     * @param string $body
     * @return $this
     */
    public function setBody(string $body)
    {
        $this->guzzleParams['body'] = $body;
        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->guzzleParams['body'];
    }

    /**
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        $this->guzzleParams['headers'] = $headers;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->guzzleParams['headers'];
    }

    /**
     * @param string $accept
     * @return $this
     */
    public function setAccept(string $accept)
    {
        $this->guzzleParams['headers']['Accept'] = $accept;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccept()
    {
        return $this->guzzleParams['headers']['Accept'];
    }

    /**
     * @param string $contentType
     * @return void
     */
    public function setContentType(string $contentType)
    {
        $this->guzzleParams['headers']['Content-Type'] = $contentType;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentType()
    {
        return $this->guzzleParams['headers']['Content-Type'];
    }

    /**
     * @param integer $contentLength
     * @return $this
     */
    public function setContentLength(int $contentLength)
    {
        $this->guzzleParams['headers']['Content-Length'] = $contentLength;
        return $this;
    }

    /**
     * @return integer
     */
    public function getContentLength()
    {
        return $this->guzzleParams['headers']['Content-Length'];
    }

    /**
     * @param float $timeout
     * @return $this
     */
    public function setTimeout(float $timeout)
    {
        $this->guzzeParams['timeout'] = $timeout;
        return $this;
    }

    /**
     * @return float
     */
    public function getTimeout()
    {
        return $this->guzzeParams['timeout'];
    }

    /**
     * @param string $url
     * @return Psr\Http\Message\ResponseInterface
     */
    public function call(string $method, string $url)
    {
        return $this->client->{$method}($url, $this->guzzleParams);
    }

}