<?php namespace App\Contracts;

/**
 * Interface RestClientContract
 * @package App\Contracts
 * @license MIT
 */
interface RestClientContract
{
    /**
     * @param string $body
     * @return void
     */
    public function setBody(string $body);

    /**
     * return void
     */
    public function getBody();

    /**
     * @param array $headers
     * @return void
     */
    public function setHeaders(array $headers);

    /**
     * @return void
     */
    public function getHeaders();

    /**
     * @param string $accept
     * @return void
     */
    public function setAccept(string $accept);

    /**
     * @return void
     */
    public function getAccept();

    /**
     * @param string $contentType
     * @return void
     */
    public function setContentType(string $contentType);

    /**
     * @return void
     */
    public function getContentType();

    /**
     * @param integer $contentLength
     * @return void
     */
    public function setContentLength(int $contentLength);

    /**
     * @return void
     */
    public function getContentLength();

    /**
     * @param float $timeout
     * @return void
     */
    public function setTimeout(float $timeout);

    /**
     * @return void
     */
    public function getTimeout();

    /**
     * @param string $method
     * @param string $url
     * @return void
     */
    public function call(string $method, string $url);
}