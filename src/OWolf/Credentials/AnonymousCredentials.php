<?php

namespace OWolf\Credentials;

use League\OAuth2\Client\Provider\AbstractProvider;
use OWolf\Contracts\CredentialsInterface;
use Psr\Http\Message\RequestInterface;

class AnonymousCredentials implements CredentialsInterface
{
    /**
     * @var \League\OAuth2\Client\Provider\AbstractProvider
     */
    protected $provider;

    /**
     * AnonymousCredentials constructor.
     * @param \League\OAuth2\Client\Provider\AbstractProvider $provider
     */
    public function __construct(AbstractProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @param  string  $method
     * @param  string  $url
     * @param  array   $options
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest($method, $url, array $options = [])
    {
        return $this->provider->getRequestFactory()->getRequestWithOptions($method, $url, $options);
    }

    /**
     * @param  \Psr\Http\Message\RequestInterface  $request
     * @return mixed
     *
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function getParsedResponse(RequestInterface $request)
    {
        return $this->provider->getParsedResponse($request);
    }
}
