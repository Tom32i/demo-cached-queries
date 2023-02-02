<?php

namespace App\Metric;

class MyMetricCalculator
{
    public function getMetricsForUser(int $userId)
    {
        sleep(5);

        $commits = rand(10000, 100000);
        $pullRequests = rand(1000, 10000);

        return [
            'id' => $userId,
            'commit' => $commits,
            'commitPerHour' => $commits / 8760,
            'pullRequest' => $pullRequests,
            'pullRequestPerHour' => $pullRequests / 8760
        ];
    }
}
