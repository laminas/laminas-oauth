<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\OAuth\Signature;

/**
 * @category   Laminas
 * @package    Laminas_OAuth
 */
class Plaintext extends AbstractSignature
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
        if ($this->_tokenSecret === null) {
            return $this->_consumerSecret . '&';
        }
        $return = implode('&', array($this->_consumerSecret, $this->_tokenSecret));
        return $return;
    }
}
