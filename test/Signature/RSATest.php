<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\OAuth\Signature;

use PHPUnit\Framework\TestCase;

class RSATest extends TestCase
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
