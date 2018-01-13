<?php

namespace OWolf\Credentials;

use League\OAuth2\Client\Provider\AbstractProvider;
use OWolf\Contracts\CredentialsInterface;
use Psr\Http\Message\RequestInterface;

class ClientIdCredentials implements CredentialsInterface
{
    /**
     * @var \League\OAuth2\Client\Provider\AbstractProvider
     */
    protected $provider;

    /**
     * @var string
     */
    protected $clientId;

    /**
     * ClientIdCredentials constructor.
     * @param \League\OAuth2\Client\Provider\AbstractProvider $provider
     * @param string  $clientId
     */
    public function __construct(AbstractProvider $provider, $clientId)
    {
        $this->provider = $provider;
        $this->clientId = $clientId;
    }

    /**
     * @param  string  $method
     * @param  string  $url
     * @param  array   $options
     * @return \GuzzleHttp\Psr7\Request
     */
    public function getRequest($method, $url, array $options = [])
    {
        $options['headers']['Authorization'] = 'Client-ID ' . $this->clientId;

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
