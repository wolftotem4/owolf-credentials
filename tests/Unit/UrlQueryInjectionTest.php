<?php

namespace Tests\Unit;

use OWolf\UrlQueryInjection;
use Tests\TestCase;

class UrlQueryInjectionTest extends TestCase
{
    public function testInjectQuery()
    {
        $url = 'http://mock.domain:8080/mock_path?query=value&second=1#fragments';
        $query = ['key' => 'value'];

        $expects = 'http://mock.domain:8080/mock_path?query=value&second=1&key=value#fragments';
        $actual = UrlQueryInjection::injectQuery($url, $query);

        $this->assertEquals($expects, $actual);
    }
}
