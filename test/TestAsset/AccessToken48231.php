<?php

declare(strict_types=1);

namespace LaminasTest\OAuth\TestAsset;

use Laminas\OAuth\Http\AccessToken;
use Laminas\OAuth\Token\Access;

class AccessToken48231 extends AccessToken
{
    public function __construct()
    {
    }

    public function execute(?array $params = null)
    {
        return new Access();
    }

    public function setParams(array $customServiceParameters)
    {
    }
}
