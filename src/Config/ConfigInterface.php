<?php

declare(strict_types=1);

namespace Laminas\OAuth\Config;

use Laminas\OAuth\Token\TokenInterface;

interface ConfigInterface
{
    public function setOptions(array $options);

    public function setConsumerKey(string $key);

    public function getConsumerKey();

    public function setConsumerSecret(string $secret);

    public function getConsumerSecret();

    public function setSignatureMethod(string $method);

    public function getSignatureMethod();

    public function setRequestScheme(string $scheme);

    public function getRequestScheme();

    public function setVersion(string $version);

    public function getVersion();

    public function setCallbackUrl(string $url);

    public function getCallbackUrl();

    public function setRequestTokenUrl(string $url);

    public function getRequestTokenUrl();

    public function setRequestMethod(string $method);

    public function getRequestMethod();

    public function setAccessTokenUrl(string $url);

    public function getAccessTokenUrl();

    public function setUserAuthorizationUrl(string $url);

    public function getUserAuthorizationUrl();

    public function setToken(TokenInterface $token);

    public function getToken();
}
