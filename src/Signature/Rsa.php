<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\OAuth\Signature;

use Laminas\Crypt\PublicKey\Rsa as RsaEnc;
use Laminas\Crypt\PublicKey\RsaOptions as RsaEncOptions;

/**
 * @category   Laminas
 * @package    Laminas_OAuth
 */
class Rsa extends AbstractSignature
{
    /**
     * Sign a request
     *
     * @param  array $params
     * @param  null|string $method
     * @param  null|string $url
     * @return string
     */
    public function sign(array $params, $method = null, $url = null)
    {
        $rsa = new RsaEnc(new RsaEncOptions([
            'hash_algorithm' => $this->hashAlgorithm,
            'binary_output'   => true
        ]));

        return $rsa->sign($this->getBaseSignatureString($params, $method, $url), $this->key);
    }

    /**
     * Assemble encryption key
     *
     * @return string
     */
    protected function assembleKey()
    {
        return $this->consumerSecret;
    }
}
