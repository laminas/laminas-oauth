<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth;

use Laminas\Config\Config;
use Laminas\Http\Client;
use Laminas\Http\Header;
use Laminas\OAuth\Client as OAuthClient;
use Laminas\OAuth\OAuth;
use Laminas\OAuth\Token;

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
        OAuth::clearHttpClient();
    }

    public function testCanSetCustomHttpClient()
    {
        OAuth::setHttpClient(new HTTPClient19485876());
        $this->assertInstanceOf('LaminasTest\OAuth\HttpClient19485876', OAuth::getHttpClient());
    }

    public function testGetHttpClientResetsParameters()
    {
        $client = new HTTPClient19485876();
        $client->setParameterGet(array('key'=>'value'));
        OAuth::setHttpClient($client);
        $resetClient = OAuth::getHttpClient();
        $resetClient->setUri('http://www.example.com');
        $this->assertEquals('http://www.example.com/', (string) $resetClient->getUri(true));
    }

    public function testGetHttpClientResetsAuthorizationHeader()
    {
        $client = new HTTPClient19485876();
        $client->setHeaders(array('Authorization' => 'realm="http://www.example.com",oauth_version="1.0"'));
        OAuth::setHttpClient($client);
        $resetClient = OAuth::getHttpClient();
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
        $client = new OAuthClient($config);
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

        $client = new OAuthClient($options);
        $this->assertEquals('GET', $client->getRequestMethod());
        $this->assertEquals('http://www.example.com', $client->getSiteUrl());
    }

    public function testOauthClientUsingGetRequestParametersForSignature()
    {
        $mock = $this->getMock('Laminas\OAuth\Http\Utility', array('generateTimestamp', 'generateNonce'));
        $mock->expects($this->once())->method('generateTimestamp')->will($this->returnValue('123456789'));
        $mock->expects($this->once())->method('generateNonce')->will($this->returnValue('67648c83ba9a7de429bd1b773fb96091'));

        $token = new Token\Access(null, $mock);
        $token->setToken('123')
              ->setTokenSecret('456');

        $client = new OAuthClient(array(
            'token' => $token
        ), 'http://www.example.com');
        $client->getRequest()->getQuery()->set('foo', 'bar');
        $client->prepareOAuth();

        $header = 'OAuth realm="",oauth_consumer_key="",oauth_nonce="67648c83ba9a7de429bd1b773fb96091",oauth_signature_method="HMAC-SHA1",oauth_timestamp="123456789",oauth_version="1.0",oauth_token="123",oauth_signature="fzWiYe4gZ2wkEMp9bEzWnlD88KE%3D"';
        $this->assertEquals($header, $client->getHeader('Authorization'));
    }

    public function testOauthClientUsingPostRequestParametersForSignature()
    {
        $mock = $this->getMock('Laminas\OAuth\Http\Utility', array('generateTimestamp', 'generateNonce'));
        $mock->expects($this->once())->method('generateTimestamp')->will($this->returnValue('123456789'));
        $mock->expects($this->once())->method('generateNonce')->will($this->returnValue('67648c83ba9a7de429bd1b773fb96091'));

        $token = new Token\Access(null, $mock);
        $token->setToken('123')
              ->setTokenSecret('456');

        $client = new OAuthClient(array(
            'token' => $token
        ), 'http://www.example.com');
        $client->getRequest()->getPost()->set('foo', 'bar');
        $client->prepareOAuth();

        $header = 'OAuth realm="",oauth_consumer_key="",oauth_nonce="67648c83ba9a7de429bd1b773fb96091",oauth_signature_method="HMAC-SHA1",oauth_timestamp="123456789",oauth_version="1.0",oauth_token="123",oauth_signature="fzWiYe4gZ2wkEMp9bEzWnlD88KE%3D"';
        $this->assertEquals($header, $client->getHeader('Authorization'));
    }

    public function testOauthClientUsingPostAndGetRequestParametersForSignature()
    {
        $mock = $this->getMock('Laminas\OAuth\Http\Utility', array('generateTimestamp', 'generateNonce'));
        $mock->expects($this->once())->method('generateTimestamp')->will($this->returnValue('123456789'));
        $mock->expects($this->once())->method('generateNonce')->will($this->returnValue('67648c83ba9a7de429bd1b773fb96091'));

        $token = new Token\Access(null, $mock);
        $token->setToken('123')
              ->setTokenSecret('456');

        $client = new OAuthClient(array(
            'token' => $token
        ), 'http://www.example.com');
        $client->getRequest()->getPost()->set('foo', 'bar');
        $client->getRequest()->getQuery()->set('baz', 'bat');
        $client->prepareOAuth();

        $header = 'OAuth realm="",oauth_consumer_key="",oauth_nonce="67648c83ba9a7de429bd1b773fb96091",oauth_signature_method="HMAC-SHA1",oauth_timestamp="123456789",oauth_version="1.0",oauth_token="123",oauth_signature="qj3FYtStzP083hT9QkqCdxsMauw%3D"';
        $this->assertEquals($header, $client->getHeader('Authorization'));
    }


    public function testOAuthClientDoesntOverrideExistingHeaders()
    {
        $mock = $this->getMock('Laminas\OAuth\Http\Utility', array('generateTimestamp', 'generateNonce'));
        $mock->expects($this->once())->method('generateTimestamp')->will($this->returnValue('123456789'));
        $mock->expects($this->once())->method('generateNonce')->will($this->returnValue('67648c83ba9a7de429bd1b773fb96091'));

        $token = new Token\Access(null, $mock);
        $token->setToken('123')
              ->setTokenSecret('456');

        $client = new OAuthClient(array(
            'token' => $token
        ), 'http://www.example.com');

        $dummyHeader = Header\ContentType::fromString('Content-Type: application/octet-stream');
        $headers = $client->getRequest()->getHeaders();
        $headers->addHeaders(array($dummyHeader));
        $client->prepareOAuth();

        $this->assertTrue($client->getRequest()->getHeaders()->has('Content-Type'));
        $this->assertEquals($dummyHeader, $client->getRequest()->getHeaders()->get('Content-Type'));
    }
}

class HTTPClient19485876 extends \Laminas\Http\Client {}
