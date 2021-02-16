<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\TestAsset;

use Laminas\OAuth\Http\RequestToken;
use Laminas\OAuth\Token\Request;

class RequestToken48231 extends RequestToken
{
    public function __construct()
    {
    }

    public function execute(array $params = null)
    {
        $return = new Request();
        return $return;
    }

    public function setParams(array $customServiceParameters)
    {
    }
}
