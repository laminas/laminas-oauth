<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\TestAsset;

use Laminas\OAuth\Consumer;
use Laminas\OAuth\Token\Access;
use Laminas\OAuth\Token\Request;

class Consumer48231 extends Consumer
{
    public function __construct(array $options = [])
    {
        $this->requestToken = new Request();
        $this->accessToken  = new Access();
        parent::__construct($options);
    }

    public function getCallbackUrl()
    {
        return 'http://www.example.com/local';
    }
}
