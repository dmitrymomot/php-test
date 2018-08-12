<?php namespace Tests\Task3;

use Task3\DataProvider;
use Task3\DataInterface;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Stream\StreamInterface;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\ResponseInterface;

use GuzzleHttp\Ring\Client\MockHandler;

final class DataProviderTest extends TestCase
{
    public function testCreateDataProvider()
    {
        $client = $this->createMock(ClientInterface::class);
        $this->assertInstanceOf(
            DataInterface::class,
            new DataProvider($client, 'http://testurl.local')
        );
    }

    public function testGetFunction()
    {
        $expectedResponse = ['test response data'];

        $responseBody = $this->createMock(StreamInterface::class);
        $responseBody->method('getContents')->willReturn(json_encode($expectedResponse));

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getBody')->willReturn($responseBody);


        $client = $this->createMock(ClientInterface::class);
        $client->method('createRequest')->willReturn($responseMock);

        $provider = new DataProvider($client, 'http://testurl.local');
        $this->assertEquals($expectedResponse, $provider->get(['opt1' => 'test value']));
    }
}
