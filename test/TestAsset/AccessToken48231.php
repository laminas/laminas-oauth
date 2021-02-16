<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\TestAsset;

use Laminas\OAuth\Http\AccessToken;
use Laminas\OAuth\Token\Access;

class AccessToken48231 extends AccessToken
{
    public function __construct()
    {
    }

    public function execute(array $params = null)
    {
        $return = new Access();
        return $return;
    }

    public function setParams(array $customServiceParameters)
    {
    }
}
