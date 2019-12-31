<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\Signature;

use Laminas\OAuth\Signature;

/**
 * @category   Laminas
 * @package    Laminas_OAuth
 * @subpackage UnitTests
 * @group      Laminas_OAuth
 */
class RSATest extends \PHPUnit_Framework_TestCase
{

    public function testSignatureWithoutAccessSecretIsHashedWithConsumerSecret()
    {
        $this->markTestIncomplete('Laminas\\Crypt\\Rsa finalisation outstanding');
    }

    public function testSignatureWithAccessSecretIsHashedWithConsumerAndAccessSecret()
    {
        $this->markTestIncomplete('Laminas\\Crypt\\Rsa finalisation outstanding');
    }

}
