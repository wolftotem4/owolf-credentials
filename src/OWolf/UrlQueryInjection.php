<?php

namespace OWolf;

class UrlQueryInjection
{
    /**
     * @param  string  $url
     * @param  array   $query
     * @return string
     */
    public static function injectQuery($url, array $query)
    {
        $parsed_url = parse_url($url);
        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $parsed_query);
        } else {
            $parsed_query = [];
        }
        $parsed_url['query'] = http_build_query(array_merge($parsed_query, $query), '', '&');
        return static::unparseUrl($parsed_url);
    }

    /**
     * @param  array  $parsedUrl
     * @return string
     */
    protected static function unparseUrl(array $parsedUrl)
    {
        $scheme   = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
        $host     = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
        $port     = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
        $user     = isset($parsedUrl['user']) ? $parsedUrl['user'] : '';
        $pass     = isset($parsedUrl['pass']) ? ':' . $parsedUrl['pass']  : '';
        $pass     = ($user || $pass) ? "$pass@" : '';
        $path     = isset($parsedUrl['path']) ? $parsedUrl['path'] : '';
        $query    = isset($parsedUrl['query']) ? '?' . $parsedUrl['query'] : '';
        $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';
        return "$scheme$user$pass$host$port$path$query$fragment";
    }
}