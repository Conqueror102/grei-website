<?php

namespace App\Services\Booking;

final class BookingResult
{
    public function __construct(
        public readonly string $status,      // requested | confirmed
        public readonly string $reference,
        public readonly ?string $paymentUrl = null, // for engines that hand off to checkout
    ) {}
}
