<?php namespace Tests\Task3;

use Task3\DataProvider;
use Task3\DataInterface;
use Task3\CacheDecorator;
use GuzzleHttp\Client;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

use PHPUnit\Framework\TestCase;

use PHPUnit\Framework\MockObject\InvocationMocker;

final class CacheTest extends TestCase
{
    public function testCreateCacheDecorator()
    {
        $cacher = $this->createMock(CacheItemPoolInterface::class);
        $provider = $this->createMock(DataInterface::class);

        $this->assertInstanceOf(
            DataInterface::class,
            new CacheDecorator($provider, $cacher, 120)
        );
    }

    public function testGetFuncDataNotCached()
    {
        $expectedResponse = ['test response data'];

        $provider = $this->createMock(DataInterface::class);
        $provider->method('get')->willReturn($expectedResponse);

        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem->method('set')->willReturnSelf();
        $cacheItem->method('isHit')->willReturn(false);

        $cacher = $this->createMock(CacheItemPoolInterface::class);
        $cacher->method('getItem')->willReturn($cacheItem);

        $cacheDecorator = new CacheDecorator($provider, $cacher, 120);
        $this->assertEquals($expectedResponse, $cacheDecorator->get(['opt1' => 'test value']));
    }

    public function testGetFuncDataWasCached()
    {
        $expectedResponse = ['test response data'];

        $provider = $this->createMock(DataInterface::class);

        $cacheItem = $this->createMock(CacheItemInterface::class);
        $cacheItem->method('isHit')->willReturn(true);
        $cacheItem->method('get')->willReturn($expectedResponse);

        $cacher = $this->createMock(CacheItemPoolInterface::class);
        $cacher->method('getItem')->willReturn($cacheItem);

        $cacheDecorator = new CacheDecorator($provider, $cacher, 120);
        $this->assertEquals($expectedResponse, $cacheDecorator->get(['opt1' => 'test value']));
    }
}
