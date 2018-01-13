<?php

namespace OWolf\Credentials;

use OWolf\UrlQueryInjection;

class UrlAccessToeknCredentials extends AccessTokenCredentials
{
    /**
     * @param  string  $method
     * @param  string  $url
     * @param  array   $options
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequest($method, $url, array $options = [])
    {
        $url = $this->injectAcessTokenToUrl($url);
        return parent::getRequest($method, $url, $options);
    }

    /**
     * @param  string  $url
     * @return string
     */
    protected function injectAcessTokenToUrl($url)
    {
        $access_token = $this->getAccessToken()->getToken();
        return UrlQueryInjection::injectQuery($url, compact('access_token'));
    }
}