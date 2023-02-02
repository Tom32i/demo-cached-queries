<?php

namespace App\Query;

use App\Middleware\CachableQueryResult;

/**
 * Get all the metrics!
 */
class GetUserMetricsQuery implements CachableQueryResult
{
    public function __construct(
        public int $userId
    ) {
    }

    public function getCacheKey(): string
    {
        return sprintf('user_metrics_%s', $this->userId);
    }

    public function getLifeTime(): ?int
    {
        return 30; // in seconds
    }
}
