<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\TestAsset;

use Laminas\OAuth\Token\Request;

class RequestToken39745 extends Request
{
    public function getToken()
    {
        return '0987654321';
    }
}
