<?php

namespace Tests\Unit\Credentials;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use Mockery;
use OWolf\Credentials\AccessTokenCredentials;
use Psr\Http\Message\RequestInterface;
use Tests\TestCase;

class AccessTokenCredentialsTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface|\League\OAuth2\Client\Provider\AbstractProvider
     */
    protected $providerMock;

    /**
     * @var \League\OAuth2\Client\Token\AccessToken
     */
    protected $accessToken;

    /**
     * @var \OWolf\Credentials\AccessTokenCredentials
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
        $this->accessToken = new AccessToken(['access_token' => 'mock_access_token']);
        $this->credentials = new AccessTokenCredentials($this->providerMock, $this->accessToken);
        $this->requestMock = Mockery::mock(RequestInterface::class);
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
            ->shouldReceive('getAuthenticatedRequest')
            ->once()
            ->with($method, $url, $this->accessToken, $options)
            ->andReturn($this->requestMock);

        $request = $this->credentials->getRequest($method, $url, $options);

        $this->assertEquals($this->requestMock, $request);
    }

    public function testGetParsedResponse()
    {
        $this->providerMock
            ->shouldReceive('getParsedResponse')
            ->once()
            ->with($this->requestMock)
            ->andReturn($expects = new \stdClass());

        $returnValue = $this->credentials->getParsedResponse($this->requestMock);

        $this->assertSame($expects, $returnValue);
    }

    public function testGetProvider()
    {
        $this->assertSame($this->providerMock, $this->credentials->getProvider());
    }

    public function testGetAccessToken()
    {
        $this->assertSame($this->accessToken, $this->credentials->getAccessToken());
    }
}
