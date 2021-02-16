<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth;

use Laminas\OAuth\Consumer;
use Laminas\OAuth\Http;
use Laminas\OAuth\OAuth;
use Laminas\OAuth\Token;
use LaminasTest\OAuth\TestAsset\AccessToken48231;
use LaminasTest\OAuth\TestAsset\Consumer48231;
use LaminasTest\OAuth\TestAsset\RequestToken48231;
use PHPUnit\Framework\TestCase;

class ConsumerTest extends TestCase
{
    public function teardown()
    {
        OAuth::clearHttpClient();
    }

    public function testConstructorSetsConsumerKey()
    {
        $config = array('consumerKey'=>'1234567890');
        $consumer = new Consumer($config);
        $this->assertEquals('1234567890', $consumer->getConsumerKey());
    }

    public function testConstructorSetsConsumerSecret()
    {
        $config = array('consumerSecret'=>'0987654321');
        $consumer = new Consumer($config);
        $this->assertEquals('0987654321', $consumer->getConsumerSecret());
    }

    public function testSetsSignatureMethodFromOptionsArray()
    {
        $options = array(
            'signatureMethod' => 'rsa-sha1'
        );
        $consumer = new Consumer($options);
        $this->assertEquals('RSA-SHA1', $consumer->getSignatureMethod());
    }

    public function testSetsRequestMethodFromOptionsArray() // add back
    {
        $options = array(
            'requestMethod' => OAuth::GET
        );
        $consumer = new Consumer($options);
        $this->assertEquals(OAuth::GET, $consumer->getRequestMethod());
    }

    public function testSetsRequestSchemeFromOptionsArray()
    {
        $options = array(
            'requestScheme' => OAuth::REQUEST_SCHEME_POSTBODY
        );
        $consumer = new Consumer($options);
        $this->assertEquals(OAuth::REQUEST_SCHEME_POSTBODY, $consumer->getRequestScheme());
    }

    public function testSetsVersionFromOptionsArray()
    {
        $options = array(
            'version' => '1.1'
        );
        $consumer = new Consumer($options);
        $this->assertEquals('1.1', $consumer->getVersion());
    }

    public function testSetsCallbackUrlFromOptionsArray()
    {
        $options = array(
            'callbackUrl' => 'http://www.example.com/local'
        );
        $consumer = new Consumer($options);
        $this->assertEquals('http://www.example.com/local', $consumer->getCallbackUrl());
    }

    public function testSetsRequestTokenUrlFromOptionsArray()
    {
        $options = array(
            'requestTokenUrl' => 'http://www.example.com/request'
        );
        $consumer = new Consumer($options);
        $this->assertEquals('http://www.example.com/request', $consumer->getRequestTokenUrl());
    }

    public function testSetsUserAuthorizationUrlFromOptionsArray()
    {
        $options = array(
            'userAuthorizationUrl' => 'http://www.example.com/authorize'
        );
        $consumer = new Consumer($options);
        $this->assertEquals('http://www.example.com/authorize', $consumer->getUserAuthorizationUrl());
    }

    public function testSetsAccessTokenUrlFromOptionsArray()
    {
        $options = array(
            'accessTokenUrl' => 'http://www.example.com/access'
        );
        $consumer = new Consumer($options);
        $this->assertEquals('http://www.example.com/access', $consumer->getAccessTokenUrl());
    }

    public function testSetSignatureMethodThrowsExceptionForInvalidMethod()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer($config);

        $this->expectException('Laminas\OAuth\Exception\ExceptionInterface');
        $consumer->setSignatureMethod('buckyball');
    }

    public function testSetRequestMethodThrowsExceptionForInvalidMethod()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer($config);

        $this->expectException('Laminas\OAuth\Exception\ExceptionInterface');
        $consumer->setRequestMethod('buckyball');
    }

    public function testSetRequestSchemeThrowsExceptionForInvalidMethod()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer($config);

        $this->expectException('Laminas\OAuth\Exception\ExceptionInterface');
        $consumer->setRequestScheme('buckyball');
    }

    public function testSetLocalUrlThrowsExceptionForInvalidUrl()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer($config);

        $this->expectException('Laminas\OAuth\Exception\ExceptionInterface');
        $consumer->setLocalUrl('buckyball');
    }

    public function testSetRequestTokenUrlThrowsExceptionForInvalidUrl()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer($config);

        $this->expectException('Laminas\OAuth\Exception\ExceptionInterface');
        $consumer->setRequestTokenUrl('buckyball');
    }

    public function testSetUserAuthorizationUrlThrowsExceptionForInvalidUrl()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer($config);

        $this->expectException('Laminas\OAuth\Exception\ExceptionInterface');
        $consumer->setUserAuthorizationUrl('buckyball');
    }

    public function testSetAccessTokenUrlThrowsExceptionForInvalidUrl()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer($config);

        $this->expectException('Laminas\OAuth\Exception\ExceptionInterface');
        $consumer->setAccessTokenUrl('buckyball');
    }

    public function testGetRequestTokenReturnsInstanceOfOauthTokenRequest()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer($config);
        $token = $consumer->getRequestToken(null, null, new RequestToken48231());
        $this->assertInstanceOf('Laminas\OAuth\Token\Request', $token);
    }

    public function testGetRedirectUrlReturnsUserAuthorizationUrlWithParameters()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321',
            'userAuthorizationUrl'=>'http://www.example.com/authorize');
        $consumer = new Consumer48231($config);
        $params = array('foo'=>'bar');
        $uauth = new Http\UserAuthorization($consumer, $params);
        $token = new Token\Request;
        $token->setParams(array('oauth_token'=>'123456', 'oauth_token_secret'=>'654321'));
        $redirectUrl = $consumer->getRedirectUrl($params, $token, $uauth);
        $this->assertEquals(
            'http://www.example.com/authorize?oauth_token=123456&oauth_callback=http%3A%2F%2Fwww.example.com%2Flocal&foo=bar',
            $redirectUrl
        );
    }

    public function testGetAccessTokenReturnsInstanceOfOauthTokenAccess()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer($config);
        $rtoken = new Token\Request;
        $rtoken->setToken('token');
        $token = $consumer->getAccessToken(array('oauth_token'=>'token'), $rtoken, null, new AccessToken48231());
        $this->assertInstanceOf('Laminas\OAuth\Token\Access', $token);
    }

    public function testGetLastRequestTokenReturnsInstanceWhenExists()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer48231($config);
        $this->assertInstanceOf('Laminas\OAuth\Token\Request', $consumer->getLastRequestToken());
    }

    public function testGetLastAccessTokenReturnsInstanceWhenExists()
    {
        $config = array('consumerKey'=>'12345','consumerSecret'=>'54321');
        $consumer = new Consumer48231($config);
        $this->assertInstanceOf('Laminas\OAuth\Token\Access', $consumer->getLastAccessToken());
    }
}
