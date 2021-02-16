<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\OAuth\Signature;

use Laminas\Crypt\Hmac as HMACEncryption;

/**
 * @category   Laminas
 * @package    Laminas_OAuth
 */
class Hmac extends AbstractSignature
{
    /**
     * Sign a request
     *
     * @param  array $params
     * @param  mixed $method
     * @param  mixed $url
     * @return string
     */
    public function sign(array $params, $method = null, $url = null)
    {
        $binaryHash = HMACEncryption::compute(
            $this->_key,
            $this->_hashAlgorithm,
            $this->_getBaseSignatureString($params, $method, $url),
            HMACEncryption::OUTPUT_BINARY
        );
        return base64_encode($binaryHash);
    }
}
