<?php namespace Tests\Task3;

use Task3\DataProvider;
use Task3\CacheDecorator;
use Task3\LoggerDecorator;
use Psr\Log\LoggerInterface;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Stream\StreamInterface;
use GuzzleHttp\Message\ResponseInterface;

class ChainDecoratorsTest extends TestCase
{
    public function testGetFunctionWithCacherAndLogger()
    {
        $expectedResponse = ['test response data'];

        // Set client
        $responseBody = $this->createMock(StreamInterface::class);
        $responseBody->method('getContents')->willReturn(json_encode($expectedResponse));

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getStatusCode')->willReturn(200);
        $responseMock->method('getBody')->willReturn($responseBody);

        $client = $this->createMock(ClientInterface::class);
        $client->method('createRequest')->willReturn($responseMock);

        // Set DataProvider
        $dataProvider = new DataProvider($client, 'http://testurl.local');

        // Set cache decorator
        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem->method('set')->willReturnSelf();
        $cacheItem->method('isHit')->willReturn(false);

        $cacher = $this->createMock(CacheItemPoolInterface::class);
        $cacher->method('getItem')->willReturn($cacheItem);

        $cacheDecorator = new CacheDecorator($dataProvider, $cacher, 120);

        // Set logger decorator
        $logger = $this->createMock(LoggerInterface::class);
        $loggerDecorator = new LoggerDecorator($cacheDecorator, $logger);

        $this->assertEquals($expectedResponse, $loggerDecorator->get(['opt1' => 'test value']));
    }
}
