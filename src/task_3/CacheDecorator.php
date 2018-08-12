<?php namespace Task3;

use DateTime;
use DateInterval;

use Carbon\Carbon;

use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class CacheDecorator extends AbstractDecorator
{
    /**
     * Cache interactor instance
     *
     * @var CacheItemPoolInterface
     */
    protected $_cacher;

    /**
     * Cache life time, set in seconds
     *
     * @var int
     */
    protected $_cacheLifetime;

    /**
     * @param DataInterface $provider
     * @param CacheItemPoolInterface $cacher
     * @param int $cacheLifetime in seconds
     */
    public function __construct(DataInterface $provider, CacheItemPoolInterface $cacher, int $cacheLifetime)
    {
        $this->_cacher = $cacher;
        parent::__construct($provider);
    }

    /**
     * Get some data of external service from cache if exist
     *
     * @param array $opt Request options
     *
     * @return array
     */
    public function get(array $opt): array
    {
        /** @var CacheItemInterface */
        $response = $this->getCacher()->getItem($this->getCacheKey($opt));
        if (!$response->isHit()) {
            $result = $this->getProvider()->get($opt);
            if (!empty($result)) {
                $response->set($result)->expiresAt(Carbon::now()->addSeconds($this->_cacheLifetime));
            }
        } else {
            $result = $response->get();
        }

        return $result;
    }

    /**
     * Generates cache kay by request options
     *
     * @param array $opt
     *
     * @return string
     */
    protected function getCacheKey(array $opt): string
    {
        array_multisort($opt);
        return md5(serialize($opt));
    }

    /**
     * Get instance of cache provider
     *
     * @return CacheItemPoolInterface
     */
    protected function getCacher(): CacheItemPoolInterface
    {
        return $this->_cacher;
    }
}
