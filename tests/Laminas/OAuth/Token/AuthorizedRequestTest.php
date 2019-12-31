<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\Token;

use Laminas\OAuth\Token\AuthorizedRequest as AuthorizedRequestToken;

/**
 * @category   Laminas
 * @package    Laminas_OAuth
 * @subpackage UnitTests
 * @group      Laminas_OAuth
 */
class AuthorizedRequestTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructorSetsInputData()
    {
        $data = array('foo'=>'bar');
        $token = new AuthorizedRequestToken($data);
        $this->assertEquals($data, $token->getData());
    }

    public function testConstructorParsesAccessTokenFromInputData()
    {
        $data = array(
            'oauth_token'=>'jZaee4GF52O3lUb9'
        );
        $token = new AuthorizedRequestToken($data);
        $this->assertEquals('jZaee4GF52O3lUb9', $token->getToken());
    }

    public function testPropertyAccessWorks()
    {
        $data = array(
            'oauth_token'=>'jZaee4GF52O3lUb9'
        );
        $token = new AuthorizedRequestToken($data);
        $this->assertEquals('jZaee4GF52O3lUb9', $token->oauth_token);
    }

    public function testTokenCastsToEncodedQueryString()
    {
        $queryString = 'oauth_token=jZaee4GF52O3lUb9&foo%20=bar~';
        $token = new AuthorizedRequestToken();
        $token->setToken('jZaee4GF52O3lUb9');
        $token->setParam('foo ', 'bar~');
        $this->assertEquals($queryString, (string) $token);
    }

    public function testToStringReturnsEncodedQueryString()
    {
        $queryString = 'oauth_token=jZaee4GF52O3lUb9';
        $token = new AuthorizedRequestToken();
        $token->setToken('jZaee4GF52O3lUb9');
        $this->assertEquals($queryString, $token->toString());
    }

    public function testIsValidDetectsBadResponse()
    {
        $data = array(
            'missing_oauth_token'=>'jZaee4GF52O3lUb9'
        );
        $token = new AuthorizedRequestToken($data);
        $this->assertFalse($token->isValid());
    }

    public function testIsValidDetectsGoodResponse()
    {
        $data = array(
            'oauth_token'=>'jZaee4GF52O3lUb9',
            'foo'=>'bar'
        );
        $token = new AuthorizedRequestToken($data);
        $this->assertTrue($token->isValid());
    }
}
