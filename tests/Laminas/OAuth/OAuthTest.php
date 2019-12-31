<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth;

use Laminas\Config\Config;
use Laminas\Http\Client;
use Laminas\OAuth;

/**
 * @category   Laminas
 * @package    Laminas_OAuth
 * @subpackage UnitTests
 * @group      Laminas_OAuth
 */
class OAuthTest extends \PHPUnit_Framework_TestCase
{

    public function teardown()
    {
        OAuth\OAuth::clearHttpClient();
    }

    public function testCanSetCustomHttpClient()
    {
        OAuth\OAuth::setHttpClient(new HTTPClient19485876());
        $this->assertInstanceOf('LaminasTest\\OAuth\\HttpClient19485876', OAuth\OAuth::getHttpClient());
    }

    public function testGetHttpClientResetsParameters()
    {
        $client = new HTTPClient19485876();
        $client->setParameterGet(array('key'=>'value'));
        OAuth\OAuth::setHttpClient($client);
        $resetClient = OAuth\OAuth::getHttpClient();
        $resetClient->setUri('http://www.example.com');
        $this->assertEquals('http://www.example.com', (string) $resetClient->getUri(true));
    }

    public function testGetHttpClientResetsAuthorizationHeader()
    {
        $client = new HTTPClient19485876();
        $client->setHeaders(array('Authorization' => 'realm="http://www.example.com",oauth_version="1.0"'));
        OAuth\OAuth::setHttpClient($client);
        $resetClient = OAuth\OAuth::getHttpClient();
        $this->assertEquals(null, $resetClient->getHeader('Authorization'));
    }

    /**
     * @group Laminas-10182
     */
    public function testOauthClientPassingObjectConfigInConstructor()
    {
        $options = array(
            'requestMethod' => 'GET',
            'siteUrl'       => 'http://www.example.com'
        );

        $config = new Config($options);
        $client = new OAuth\Client($config);
        $this->assertEquals('GET', $client->getRequestMethod());
        $this->assertEquals('http://www.example.com', $client->getSiteUrl());
    }

    /**
     * @group Laminas-10182
     */
    public function testOauthClientPassingArrayInConstructor()
    {
        $options = array(
            'requestMethod' => 'GET',
            'siteUrl'       => 'http://www.example.com'
        );

        $client = new OAuth\Client($options);
        $this->assertEquals('GET', $client->getRequestMethod());
        $this->assertEquals('http://www.example.com', $client->getSiteUrl());
    }

    public function testOauthClientUsingGetRequestParametersForSignature()
    {
        $mock = $this->getMock('Laminas\\OAuth\\Http\\Utility', array('generateTimestamp', 'generateNonce'));
        $mock->expects($this->once())->method('generateTimestamp')->will($this->returnValue('123456789'));
        $mock->expects($this->once())->method('generateNonce')->will($this->returnValue('67648c83ba9a7de429bd1b773fb96091'));

        $token   = new OAuth\Token\Access(null, $mock);
        $token->setToken('123')
              ->setTokenSecret('456');

        $client = new OAuth\Client(array(
            'token' => $token
        ), 'http://www.example.com');
        $client->getRequest()->getQuery()->set('foo', 'bar');
        $client->prepareOAuth();

        $header = 'OAuth realm="",oauth_consumer_key="",oauth_nonce="67648c83ba9a7de429bd1b773fb96091",oauth_signature_method="HMAC-SHA1",oauth_timestamp="123456789",oauth_version="1.0",oauth_token="123",oauth_signature="fzWiYe4gZ2wkEMp9bEzWnlD88KE%3D"';
        $this->assertEquals($header, $client->getHeader('Authorization'));
    }

    public function testOauthClientUsingPostRequestParametersForSignature()
    {
        $mock = $this->getMock('Laminas\\OAuth\\Http\\Utility', array('generateTimestamp', 'generateNonce'));
        $mock->expects($this->once())->method('generateTimestamp')->will($this->returnValue('123456789'));
        $mock->expects($this->once())->method('generateNonce')->will($this->returnValue('67648c83ba9a7de429bd1b773fb96091'));

        $token   = new OAuth\Token\Access(null, $mock);
        $token->setToken('123')
              ->setTokenSecret('456');

        $client = new OAuth\Client(array(
            'token' => $token
        ), 'http://www.example.com');
        $client->getRequest()->getPost()->set('foo', 'bar');
        $client->prepareOAuth();

        $header = 'OAuth realm="",oauth_consumer_key="",oauth_nonce="67648c83ba9a7de429bd1b773fb96091",oauth_signature_method="HMAC-SHA1",oauth_timestamp="123456789",oauth_version="1.0",oauth_token="123",oauth_signature="fzWiYe4gZ2wkEMp9bEzWnlD88KE%3D"';
        $this->assertEquals($header, $client->getHeader('Authorization'));
    }

    public function testOauthClientUsingPostAndGetRequestParametersForSignature()
    {
        $mock = $this->getMock('Laminas\\OAuth\\Http\\Utility', array('generateTimestamp', 'generateNonce'));
        $mock->expects($this->once())->method('generateTimestamp')->will($this->returnValue('123456789'));
        $mock->expects($this->once())->method('generateNonce')->will($this->returnValue('67648c83ba9a7de429bd1b773fb96091'));

        $token   = new OAuth\Token\Access(null, $mock);
        $token->setToken('123')
              ->setTokenSecret('456');

        $client = new OAuth\Client(array(
            'token' => $token
        ), 'http://www.example.com');
        $client->getRequest()->getPost()->set('foo', 'bar');
        $client->getRequest()->getQuery()->set('baz', 'bat');
        $client->prepareOAuth();

        $header = 'OAuth realm="",oauth_consumer_key="",oauth_nonce="67648c83ba9a7de429bd1b773fb96091",oauth_signature_method="HMAC-SHA1",oauth_timestamp="123456789",oauth_version="1.0",oauth_token="123",oauth_signature="qj3FYtStzP083hT9QkqCdxsMauw%3D"';
        $this->assertEquals($header, $client->getHeader('Authorization'));
    }
}

class HTTPClient19485876 extends \Laminas\Http\Client {}
