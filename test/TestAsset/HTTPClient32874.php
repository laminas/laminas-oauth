<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\TestAsset;

use Laminas\Http\Client;

class HTTPClient32874 extends Client
{
    public function getRawData()
    {
        return $this->getRequest()->getContent();
    }
}
