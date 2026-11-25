<?php

namespace App\Services\Booking;

use Carbon\CarbonImmutable;

final class StayQuote
{
    public function __construct(
        public readonly CarbonImmutable $checkIn,
        public readonly CarbonImmutable $checkOut,
        public readonly int $guests,
        public readonly int $nights,
        public readonly int $nightlyRate,
        public readonly int $total,
    ) {}

    public function toArray(): array
    {
        return [
            'check_in' => $this->checkIn->toDateString(),
            'check_out' => $this->checkOut->toDateString(),
            'guests' => $this->guests,
            'nights' => $this->nights,
            'nightly_rate' => $this->nightlyRate,
            'estimated_total' => $this->total,
            'currency' => config('grei.currency.code'),
        ];
    }
}
