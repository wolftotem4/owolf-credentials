<?php

namespace Tests\Unit\Credentials;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Tool\RequestFactory;
use Mockery;
use OWolf\Credentials\AnonymousCredentials;
use Psr\Http\Message\RequestInterface;
use Tests\TestCase;

class AnonymousCredentialsTest extends TestCase
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
     * @var \OWolf\Credentials\AnonymousCredentials
     */
    protected $credentials;

    /**
     * @var \Mockery\MockInterface|\Psr\Http\Message\RequestInterface
     */
    protected $requestMock;

    protected function setUp()
    {
        parent::setUp();

        $this->providerMock = Mockery::mock(AbstractProvider::class);
        $this->factoryMock  = Mockery::mock(RequestFactory::class);
        $this->credentials  = new AnonymousCredentials($this->providerMock);
        $this->requestMock  = Mockery::mock(RequestInterface::class);
    }

    protected function tearDown()
    {
        Mockery::close();

        parent::tearDown();
    }

    public function testGetRequest()
    {
        $method = 'mock_method';
        $url    = 'http://mock_url';
        $options = ['opt' => 'mock_options'];

        $this->providerMock
            ->shouldReceive('getRequestFactory')
            ->once()
            ->withNoArgs()
            ->andReturn($this->factoryMock);

        $this->factoryMock
            ->shouldReceive('getRequestWithOptions')
            ->once()
            ->with($method, $url, $options)
            ->andReturn($expects = new \stdClass());

        $returnValue = $this->credentials->getRequest($method, $url, $options);

        $this->assertSame($expects, $returnValue);
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
