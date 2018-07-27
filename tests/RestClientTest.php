<?php

use App\Services\RestClient;
use App\Contracts\RestClientContract;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Class RestClientTest
 * @license MIT
 */
class RestClientTest extends TestCase
{
    public function testRestClient()
    {
        $restClient = $this->app[RestClient::class];
        $this->assertInstanceOf(RestClientContract::class, $restClient);

        $this->describe('rest client', function () use ($restClient) {
            
            # setTimeout
            $this->it('should set time out in guzzle headers', function () use ($restClient) {
                $restClient->setTimeout(5.0);
                $this->assertEquals(5.0, $restClient->getTimeout());

                # setContentLength
                $this->it('should set content length in guzzle headers', function () use ($restClient) {
                    $restClient->setContentLength(100);
                    $this->assertEquals(5.0, $restClient->getTimeout());
                    $this->assertEquals(100, $restClient->getContentLength());

                    # setContentType
                    $this->it('should set content type in guzzle headers', function () use ($restClient) {
                        $restClient->setContentType('application/json');
                        $this->assertEquals(5.0, $restClient->getTimeout());
                        $this->assertEquals(100, $restClient->getContentLength());
                        $this->assertEquals('application/json', $restClient->getContentType());

                        # setAccept
                        $this->it('should set accept in guzzle headers', function () use ($restClient) {
                            $restClient->setAccept('application/json');
                            $this->assertEquals(5.0, $restClient->getTimeout());
                            $this->assertEquals(100, $restClient->getContentLength());
                            $this->assertEquals('application/json', $restClient->getContentType());
                            $this->assertEquals('application/json', $restClient->getAccept());

                            # setHeaders
                            $this->it('should set headers in guzzle headers', function () use ($restClient) {
                                $restClient->setHeaders([
                                    'X-User'         => -1,
                                    'X-Token-Scope'  => '',
                                    'X-Client-Ip'    => '192.168.100.1',
                                    'User-Agent'     => '',
                                    'Content-Type'   => 'application/json',
                                    'Content-Length' => 100,
                                    'Accept'         => 'application/json'
                                ]);
                                $this->assertEquals(5.0, $restClient->getTimeout());
                                $this->assertEquals(100, $restClient->getContentLength());
                                $this->assertEquals('application/json', $restClient->getContentType());
                                $this->assertEquals('application/json', $restClient->getAccept());
                                $this->assertArrayHasKey('X-User', $restClient->getHeaders());

                                # setBody
                                $this->it('should set body in guzzle headers', function () use ($restClient) {
                                    $restClient->setBody('{"name":"harun","age":21}');
                                    $this->assertEquals(5.0, $restClient->getTimeout());
                                    $this->assertEquals(100, $restClient->getContentLength());
                                    $this->assertEquals('application/json', $restClient->getContentType());
                                    $this->assertEquals('application/json', $restClient->getAccept());
                                    $this->assertArrayHasKey('X-User', $restClient->getHeaders());
                                    $this->assertEquals('{"name":"harun","age":21}', $restClient->getBody());
            
                                });
                            });
                        });
                    });
                });
            });
        });
    } 
}
