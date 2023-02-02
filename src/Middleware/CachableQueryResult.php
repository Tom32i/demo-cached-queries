<?php

namespace App\Middleware;

interface CachableQueryResult
{
    public function getCacheKey(): string;
    public function getLifeTime(): ?int;
}
