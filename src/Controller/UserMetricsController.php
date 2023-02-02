<?php

namespace App\Controller;

use App\Query\GetUserMetricsQuery;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserMetricsController
{
    public function __construct(
        private MessageBusInterface $bus
    ) {

    }

    #[Route('/metrics/user/{id}', methods: ['GET'])]
    public function __invoke(int $id): JsonResponse
    {
        $envelope = $this->bus->dispatch(
            new GetUserMetricsQuery($id)
        );

        return new JsonResponse(
            $envelope->last(HandledStamp::class)->getResult()
        );
    }
}
