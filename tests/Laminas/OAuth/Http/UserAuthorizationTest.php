<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\Http;

use Laminas\OAuth\Consumer;
use Laminas\OAuth\Http;

/**
 * @category   Laminas
 * @package    Laminas_OAuth
 * @subpackage UnitTests
 * @group      Laminas_OAuth
 */
class UserAuthorizationTest extends \PHPUnit_Framework_TestCase
{

    protected $stubConsumer = null;

    public function setup()
    {
        $this->stubConsumer = new Consumer34879;
    }

    public function testConstructorSetsConsumerInstance()
    {
        $redirect = new Http\UserAuthorization($this->stubConsumer);
        $this->assertInstanceOf('LaminasTest\OAuth\Http\Consumer34879', $redirect->getConsumer());
    }

    public function testConstructorSetsCustomServiceParameters()
    {
        $redirect = new Http\UserAuthorization($this->stubConsumer, array(1,2,3));
        $this->assertEquals(array(1,2,3), $redirect->getParameters());
    }

    public function testAssembleParametersReturnsUserAuthorizationParamArray()
    {
        $redirect = new Http\UserAuthorization($this->stubConsumer, array('foo '=>'bar~'));
        $expected = array(
            'oauth_token'=>'1234567890',
            'oauth_callback'=>'http://www.example.com/local',
            'foo '=>'bar~'
        );
        $this->assertEquals($expected, $redirect->assembleParams());
    }

    public function testGetUrlReturnsEncodedQueryStringParamsAppendedToLocalUrl()
    {
        $redirect = new Http\UserAuthorization($this->stubConsumer, array('foo '=>'bar~'));
        $expected =
            'http://www.example.com/authorize?oauth_token=1234567890&oauth_callback=http%3A%2F%2Fwww.example.com%2Flocal&foo%20=bar~';
        $this->assertEquals($expected, $redirect->getUrl());
    }

}

class Consumer34879 extends Consumer
{
    public function getUserAuthorizationUrl(){return 'http://www.example.com/authorize';}
    public function getCallbackUrl(){return 'http://www.example.com/local';}
    public function getLastRequestToken(){$r=new Token34879;return $r;}
}
class Token34879
{
    public function getToken(){return '1234567890';}
}
