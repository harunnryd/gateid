<?php namespace App\Contracts;

/**
 * Interface GatewayContract
 * @package App\Contracts
 * @license MIT
 */
interface GatewayContract {

    /**
     * @return void
     */
    public function decode();

    /**
     * @return void
     */
    public function encode();

    /**
     * @return void
     */
    public function count(string $param);
}