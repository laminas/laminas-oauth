<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\TestAsset;

use Laminas\OAuth\Config\StandardConfig;
use Laminas\OAuth\Token\Access;

class Config90244 extends StandardConfig
{
    public function getConsumerKey()
    {
        return '1234567890';
    }

    public function getSignatureMethod()
    {
        return 'HMAC-SHA1';
    }

    public function getVersion()
    {
        return '1.0';
    }

    public function getRequestTokenUrl()
    {
        return 'http://www.example.com/request';
    }

    public function getToken()
    {
        $token = new Access();
        $token->setToken('abcde');
        return $token;
    }

    public function getRequestMethod()
    {
        return 'POST';
    }
}
