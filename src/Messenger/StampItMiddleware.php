<?php

declare(strict_types=1);

namespace App\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;

class StampItMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        if (null === $envelope->last(MyCustomStamp::class)) {
            $envelope = $envelope->with(new MyCustomStamp(uniqid('stamp_', true)));
        }

//        /** @var MyCustomStamp $stamp */
//        $stamp = $envelope->last(MyCustomStamp::class);
//
//        file_put_contents('/app/middleware.txt', $stamp->getValue());

        return $stack->next()->handle($envelope, $stack);
    }
}
