<?php

namespace App\Middleware;

use App\Stamp\RefreshCacheStamp;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class CacheMiddleware implements MiddlewareInterface
{
    public function __construct(
        private AdapterInterface $cache,
    ) {
    }

    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        $message = $envelope->getMessage();

        if (!$message instanceof CachableQueryResult) {
            return $this->continue($envelope, $stack);
        }

        $force = $envelope->last(RefreshCacheStamp::class) !== null;
        $item = $this->cache->getItem($message->getCacheKey());

        if ($force || !$item->isHit()) {
            if ($lifetime = $message->getLifeTime()) {
                $item->expiresAfter($lifetime);
            }

            $item->set($this->continue($envelope, $stack));
            $this->cache->save($item);
        }

        return $item->get();
    }

    private function continue(Envelope $envelope, StackInterface $stack): Envelope
    {
        return $stack->next()->handle($envelope, $stack);
    }
}
