<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\Config;

use Laminas\OAuth\Config\StandardConfig;
use PHPUnit\Framework\TestCase;

class StandardConfigurationTest extends TestCase
{
    public function testSiteUrlArePropertlyBuiltFromDefaultPaths()
    {
        $config = new StandardConfig(
            array(
                'siteUrl'	=> 'https://example.com/oauth/'
            )
        );
        $this->assertEquals('https://example.com/oauth/authorize', $config->getAuthorizeUrl());
        $this->assertEquals('https://example.com/oauth/request_token', $config->getRequestTokenUrl());
        $this->assertEquals('https://example.com/oauth/access_token', $config->getAccessTokenUrl());

    }
}
