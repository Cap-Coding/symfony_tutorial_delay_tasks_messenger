<?php

declare(strict_types=1);

namespace App\Messenger;

use App\Dto\Transformer\Request\ReservationRequestDtoTransformer;
use App\Entity\Reservation;
use App\Exception\ApiClientException;
use App\Service\ApiClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ReservationHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $entityManager;
    private ReservationRequestDtoTransformer $requestReservationTransformer;
    private ApiClient $apiClient;
    private LoggerInterface $logger;

    public function __construct(
        EntityManagerInterface $entityManager,
        ReservationRequestDtoTransformer $requestReservationTransformer,
        ApiClient $apiClient,
        LoggerInterface $logger
    ) {
        $this->entityManager = $entityManager;
        $this->requestReservationTransformer = $requestReservationTransformer;
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function __invoke(ReservationMessage $message)
    {
        $reservationRepository = $this->entityManager->getRepository(Reservation::class);

        $reservation = $reservationRepository->findOneBy(['id' => $message->getReservationId()]);

        if (!$reservation) {
            return;
        }

        $requestDto = $this->requestReservationTransformer->transformFromObject($reservation);

        try {
            $response = $this->apiClient->send(
                'POST',
                'v1/very/slow/endpoint',
                $requestDto
            );
        } catch (ApiClientException $e) {
            $this->logger->error('Error during API call: ' . $e->getMessage());
        }

        // Do something with response
    }
}