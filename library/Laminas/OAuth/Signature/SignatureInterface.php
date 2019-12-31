<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\OAuth\Signature;

interface SignatureInterface
{
    /**
     * Constructor
     *
     * @param  string $consumerSecret
     * @param  null|string $tokenSecret
     * @param  null|string $hashAlgo
     * @return void
     */
    public function __construct($consumerSecret, $tokenSecret = null, $hashAlgo = null);

    /**
     * Sign a request
     *
     * @param  array $params
     * @param  null|string $method
     * @param  null|string $url
     * @return string
     */
    public function sign(array $params, $method = null, $url = null);
}
