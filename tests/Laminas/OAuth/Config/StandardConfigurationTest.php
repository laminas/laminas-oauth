<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\Config;


/**
 * @category   Laminas
 * @package    Laminas_OAuth
 * @subpackage UnitTests
 * @group      Laminas_OAuth
 */
use Laminas\OAuth\Config\StandardConfig;

class StandardConfigurationTest extends \PHPUnit_Framework_TestCase
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

