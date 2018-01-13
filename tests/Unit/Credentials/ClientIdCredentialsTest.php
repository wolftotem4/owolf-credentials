<?php

namespace Tests\Unit\Credentials;

use GuzzleHttp\Psr7\Request;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Tool\RequestFactory;
use Mockery;
use OWolf\Credentials\ClientIdCredentials;
use Tests\TestCase;

class ClientIdCredentialsTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface|\League\OAuth2\Client\Provider\AbstractProvider
     */
    protected $providerMock;

    /**
     * @var \Mockery\MockInterface|\League\OAuth2\Client\Tool\RequestFactory
     */
    protected $factoryMock;

    /**
     * @var \OWolf\Credentials\ClientIdCredentials
     */
    protected $credentials;

    /**
     * @var \Mockery\MockInterface|\GuzzleHttp\Psr7\Request
     */
    protected $requestMock;

    protected function setUp()
    {
        parent::setUp();

        $this->providerMock = Mockery::mock(AbstractProvider::class);
        $this->factoryMock  = Mockery::mock(RequestFactory::class);
        $this->credentials  = new ClientIdCredentials($this->providerMock, 'mock_client_id');
        $this->requestMock  = Mockery::mock(Request::class);
    }

    protected function tearDown()
    {
        Mockery::close();

        parent::tearDown();
    }

    public function testGetRequest()
    {
        $method = 'mock_method';
        $url    = 'http://mock_url/';
        $options = ['opt' => 'mock_options'];

        $this->providerMock
            ->shouldReceive('getRequestFactory')
            ->once()
            ->withNoArgs()
            ->andReturn($this->factoryMock);

        $this->factoryMock
            ->shouldReceive('getRequestWithOptions')
            ->once()
            ->with($method, $url, [
                'opt' => 'mock_options',
                'headers' => [
                    'Authorization' => 'Client-ID mock_client_id',
                ],
            ])
            ->andReturn($this->requestMock);

        $request = $this->credentials->getRequest($method, $url, $options);
        $this->assertSame($this->requestMock, $request);
    }

    public function testGetParsedResponse()
    {
        $this->providerMock
            ->shouldReceive('getParsedResponse')
            ->once()
            ->with($this->requestMock)
            ->andReturn($expects = new \stdClass());

        $response = $this->credentials->getParsedResponse($this->requestMock);
        $this->assertSame($expects, $response);
    }
}
