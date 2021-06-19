<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Transformer\Response\ReservationResponseDtoTransformer;
use App\Entity\Reservation;
use App\Form\Type\ReservationType;
use App\Messenger\ReservationMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

class ReservationController extends AbstractApiController
{
    private ReservationResponseDtoTransformer $responseDtoTransformer;

    public function __construct(
        ReservationResponseDtoTransformer $reservationResponseDtoTransformer
    ) {
        $this->responseDtoTransformer = $reservationResponseDtoTransformer;
    }

    public function showAction(Request $request, MessageBusInterface $bus): Response
    {
        $reservationId = (int) $request->get('id');

        $repository = $this->getDoctrine()
            ->getRepository(Reservation::class);

        /** @var Reservation $reservation */
        $reservation = $repository->findOneBy([
            'id' => $reservationId,
        ]);

        if (!$reservation) {
            throw new NotFoundHttpException('Reservation not found');
        }

        $dto = $this->responseDtoTransformer->transformFromObject($reservation);

        $bus->dispatch(new ReservationMessage($reservationId));

//        $this->dispatchMessage(new ReservationMessage($reservationId));
//        $this->dispatchMessage(new Envelope(
//            new ReservationMessage($reservationId),
//            [new DelayStamp(5000)]
//        ));

        return $this->respond($dto);
    }

    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(ReservationType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Reservation $reservation */
        $reservation = $form->getData();

        $this->getDoctrine()->getManager()->persist($reservation);
        $this->getDoctrine()->getManager()->flush();

        $this->dispatchMessage(new ReservationMessage($reservation->getId()));

        $this->dispatchMessage(
            new Envelope(
                new ReservationMessage($reservation->getId()),
                [new DelayStamp(5000)]
            )
        );

        $dto = $this->responseDtoTransformer->transformFromObject($reservation);

        return $this->respond($dto);
    }
}
