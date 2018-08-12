<?php namespace Tests\Task3;

use Task3\DataProvider;
use Task3\DataInterface;
use Task3\LoggerDecorator;
use Task3\CoundNotGetDataException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;

use PHPUnit\Framework\TestCase;

use GuzzleHttp\Message\ResponseInterface;

final class LoggerTest extends TestCase
{
    public function testCreateLoggerDecorator()
    {
        $logger = $this->createMock(LoggerInterface::class);
        $provider = $this->createMock(DataInterface::class);

        $this->assertInstanceOf(
            DataInterface::class,
            new LoggerDecorator($provider, $logger)
        );
    }

    public function testGetFunction()
    {
        $expectedResponse = ['test response data'];

        $provider = $this->createMock(DataInterface::class);
        $provider->method('get')->willReturn($expectedResponse);
        $logger = $this->createMock(LoggerInterface::class);

        $loggerDecorator = new LoggerDecorator($provider, $logger);
        $this->assertEquals($expectedResponse, $loggerDecorator->get(['opt1' => 'test value']));
    }

    public function testGetFunctionFailed()
    {
        $this->expectException(CoundNotGetDataException::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(500);

        $client = $this->createMock(ClientInterface::class);
        $client->method('createRequest')->willReturn($responseMock);

        $provider = new DataProvider($client, 'http://testurl.local');

        $logger = $this->createMock(LoggerInterface::class);

        $loggerDecorator = new LoggerDecorator($provider, $logger);
        $loggerDecorator->get(['opt1' => 'test value']);
    }
}
