<?php

namespace Decorator;

use DateTime;
use Integration\DataProviderInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class DataProviderCacheDecorator implements DataProviderInterface
{
    private $cache;
    private $logger;
    private $wrappedDataProvider;

    /**
     * @param DataProviderInterface $dataProvider
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(
        DataProviderInterface $dataProvider,
        CacheItemPoolInterface $cache,
        LoggerInterface $logger
    )
    {
        $this->wrappedDataProvider = $dataProvider;
        $this->cache               = $cache;
        $this->logger              = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function get(array $request): array
    {
        try {
            $cacheKey  = $this->getCacheKey($request);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $result = $this->wrappedDataProvider->get($request);

            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new DateTime())->modify('+1 day')
                );

            $this->cache->save($cacheItem);

            return $result;
        } catch (\Throwable $e) {
            $this->logger->critical($e);
            throw $e;
        }
    }

    public function getCacheKey(array $request): string
    {
        return base64_encode(json_encode($request));
    }
}