<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\TestAsset;

use Laminas\OAuth\Consumer;

class Consumer34879 extends Consumer
{
    public function getUserAuthorizationUrl()
    {
        return 'http://www.example.com/authorize';
    }

    public function getCallbackUrl()
    {
        return 'http://www.example.com/local';
    }

    public function getLastRequestToken()
    {
        $r = new Token34879;
        return $r;
    }
}
