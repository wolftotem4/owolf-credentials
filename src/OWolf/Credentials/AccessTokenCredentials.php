<?php

namespace OWolf\Credentials;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use OWolf\Contracts\CredentialsInterface;
use Psr\Http\Message\RequestInterface;

class AccessTokenCredentials implements CredentialsInterface
{
    /**
     * @var \League\OAuth2\Client\Provider\AbstractProvider
     */
    protected $provider;

    /**
     * @var \League\OAuth2\Client\Token\AccessToken
     */
    protected $accessToken;

    /**
     * AccessTokenCredentials constructor.
     * @param \League\OAuth2\Client\Provider\AbstractProvider $provider
     * @param \League\OAuth2\Client\Token\AccessToken $accessToken
     */
    public function __construct(AbstractProvider $provider, AccessToken $accessToken)
    {
        $this->provider    = $provider;
        $this->accessToken = $accessToken;
    }

    /**
     * @param  string  $method
     * @param  string  $url
     * @param  array   $options
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest($method, $url, array $options = [])
    {
        return $this->provider->getAuthenticatedRequest($method, $url, $this->accessToken, $options);
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

    /**
     * @return \League\OAuth2\Client\Provider\AbstractProvider
     */
    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * @return \League\OAuth2\Client\Token\AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }
}
