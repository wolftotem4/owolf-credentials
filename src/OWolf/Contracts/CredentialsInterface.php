<?php

namespace OWolf\Contracts;

use Psr\Http\Message\RequestInterface;

interface CredentialsInterface
{
    /**
     * @param  string  $method
     * @param  string  $url
     * @param  array   $options
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest($method, $url, array $options = []);

    /**
     * @param  \Psr\Http\Message\RequestInterface  $request
     * @return mixed
     *
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function getParsedResponse(RequestInterface $request);
}
