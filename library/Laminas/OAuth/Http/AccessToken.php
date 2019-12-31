<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\OAuth\Http;

use Laminas\Http;
use Laminas\OAuth\Http as HTTPClient;
use Laminas\OAuth\OAuth;
use Laminas\OAuth\Token;

/**
 * @category   Laminas
 * @package    Laminas_OAuth
 */
class AccessToken extends HTTPClient
{
    /**
     * Singleton instance if required of the HTTP client
     *
     * @var \Laminas\Http\Client
     */
    protected $_httpClient = null;

    /**
     * Initiate a HTTP request to retrieve an Access Token.
     *
     * @return \Laminas\OAuth\Token\Access
     */
    public function execute()
    {
        $params   = $this->assembleParams();
        $response = $this->startRequestCycle($params);
        $return   = new Token\Access($response);
        return $return;
    }

    /**
     * Assemble all parameters for an OAuth Access Token request.
     *
     * @return array
     */
    public function assembleParams()
    {
        $params = array(
            'oauth_consumer_key'     => $this->_consumer->getConsumerKey(),
            'oauth_nonce'            => $this->_httpUtility->generateNonce(),
            'oauth_signature_method' => $this->_consumer->getSignatureMethod(),
            'oauth_timestamp'        => $this->_httpUtility->generateTimestamp(),
            'oauth_token'            => $this->_consumer->getLastRequestToken()->getToken(),
            'oauth_version'          => $this->_consumer->getVersion(),
        );

        if (!empty($this->_parameters)) {
            $params = array_merge($params, $this->_parameters);
        }

        $params['oauth_signature'] = $this->_httpUtility->sign(
            $params,
            $this->_consumer->getSignatureMethod(),
            $this->_consumer->getConsumerSecret(),
            $this->_consumer->getLastRequestToken()->getTokenSecret(),
            $this->_preferredRequestMethod,
            $this->_consumer->getAccessTokenUrl()
        );

        return $params;
    }

    /**
     * Generate and return a HTTP Client configured for the Header Request Scheme
     * specified by OAuth, for use in requesting an Access Token.
     *
     * @param  array $params
     * @return Laminas\Http\Client
     */
    public function getRequestSchemeHeaderClient(array $params)
    {
        $params      = $this->_cleanParamsOfIllegalCustomParameters($params);
        $headerValue = $this->_toAuthorizationHeader($params);
        $client      = OAuth::getHttpClient();

        $client->setUri($this->_consumer->getAccessTokenUrl());
        $client->setHeaders(array('Authorization' =>  $headerValue));
        $client->setMethod($this->_preferredRequestMethod);

        return $client;
    }

    /**
     * Generate and return a HTTP Client configured for the POST Body Request
     * Scheme specified by OAuth, for use in requesting an Access Token.
     *
     * @param  array $params
     * @return Laminas\Http\Client
     */
    public function getRequestSchemePostBodyClient(array $params)
    {
        $params = $this->_cleanParamsOfIllegalCustomParameters($params);
        $client = OAuth::getHttpClient();
        $client->setUri($this->_consumer->getAccessTokenUrl());
        $client->setMethod($this->_preferredRequestMethod);
        $client->setRawBody(
            $this->_httpUtility->toEncodedQueryString($params)
        );
        $client->setHeaders(array('Content-Type' => Http\Client::ENC_URLENCODED));
        return $client;
    }

    /**
     * Generate and return a HTTP Client configured for the Query String Request
     * Scheme specified by OAuth, for use in requesting an Access Token.
     *
     * @param  array $params
     * @param  string $url
     * @return Laminas\Http\Client
     */
    public function getRequestSchemeQueryStringClient(array $params, $url)
    {
        $params = $this->_cleanParamsOfIllegalCustomParameters($params);
        return parent::getRequestSchemeQueryStringClient($params, $url);
    }

    /**
     * Access Token requests specifically may not contain non-OAuth parameters.
     * So these should be striped out and excluded. Detection is easy since
     * specified OAuth parameters start with "oauth_", Extension params start
     * with "xouth_", and no other parameters should use these prefixes.
     *
     * xouth params are not currently allowable.
     *
     * @param  array $params
     * @return array
     */
    protected function _cleanParamsOfIllegalCustomParameters(array $params)
    {
        foreach ($params as $key=>$value) {
            if (!preg_match("/^oauth_/", $key)) {
                unset($params[$key]);
            }
        }
        return $params;
    }
}
