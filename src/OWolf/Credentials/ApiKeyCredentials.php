<?php

namespace OWolf\Credentials;

use League\OAuth2\Client\Provider\AbstractProvider;
use OWolf\Contracts\CredentialsInterface;
use OWolf\UrlQueryInjection;
use Psr\Http\Message\RequestInterface;

class ApiKeyCredentials implements CredentialsInterface
{
    /**
     * @var string
     */
    protected $keyName = 'key';

    /**
     * @var \League\OAuth2\Client\Provider\AbstractProvider
     */
    protected $provider;

    /**
     * @var string
     */
    protected $key;

    /**
     * ApiKeyCredentials constructor.
     * @param \League\OAuth2\Client\Provider\AbstractProvider $provider
     * @param string $key
     */
    public function __construct(AbstractProvider $provider, $key)
    {
        $this->provider = $provider;
        $this->key      = $key;
    }

    /**
     * @param  string  $method
     * @param  string  $url
     * @param  array   $options
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest($method, $url, array $options = [])
    {
        $url = $this->injectKeyToUrl($url);
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

    /**
     * @param  string  $url
     * @return string
     */
    protected function injectKeyToUrl($url)
    {
        return UrlQueryInjection::injectQuery($url, [$this->keyName => $this->key]);
    }
}
