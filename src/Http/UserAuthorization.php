<?php

/**
 * @see       https://github.com/laminas/laminas-oauth for the canonical source repository
 * @copyright https://github.com/laminas/laminas-oauth/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-oauth/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\OAuth\Http;

use Laminas\OAuth\Http as HTTPClient;
use Laminas\Uri;

/**
 * @category   Laminas
 * @package    Laminas_OAuth
 */
class UserAuthorization extends HTTPClient
{
    /**
     * Generate a redirect URL from the allowable parameters and configured
     * values.
     *
     * @return string
     */
    public function getUrl()
    {
        $params = $this->assembleParams();
        $uri    = Uri\UriFactory::factory($this->consumer->getUserAuthorizationUrl());

        $uri->setQuery(
            $this->httpUtility->toEncodedQueryString($params)
        );

        return $uri->toString();
    }

    /**
     * Assemble all parameters for inclusion in a redirect URL.
     *
     * @return array
     */
    public function assembleParams()
    {
        $params = [
            'oauth_token' => $this->consumer->getLastRequestToken()->getToken(),
        ];

        if (! \Laminas\OAuth\Client::$supportsRevisionA) {
            $callback = $this->consumer->getCallbackUrl();
            if (! empty($callback)) {
                $params['oauth_callback'] = $callback;
            }
        }

        if (! empty($this->parameters)) {
            $params = array_merge($params, $this->parameters);
        }

        return $params;
    }
}
