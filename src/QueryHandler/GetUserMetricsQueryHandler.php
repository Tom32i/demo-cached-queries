<?php

namespace App\QueryHandler;

use App\Query\GetUserMetricsQuery;
use App\Metric\MyMetricCalculator;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUserMetricsQueryHandler
{
    public function __construct(
        private MyMetricCalculator $calculator
    ) {

    }

    public function __invoke(GetUserMetricsQuery $query): array
    {
        return $this->calculator->getMetricsForUser($query->userId);
    }
}
