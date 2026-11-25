<?php

namespace App\Contracts;

use App\Models\Stay;
use App\Services\Booking\BookingResult;
use App\Services\Booking\StayQuote;
use Carbon\CarbonImmutable;

/**
 * The seam between the Stays pages and whatever takes the booking.
 *
 * Today GREI runs stays by request (EnquiryBookingProvider): the guest asks,
 * the team confirms availability and payment directly. To move to instant
 * booking, write a provider for the chosen engine or channel manager that
 * implements this interface, and bind it in AppServiceProvider. The pages and
 * forms do not need to change.
 */
interface StayBookingProvider
{
    /** "request" (enquiry, confirmed by the team) or "instant" (booked and paid online). */
    public function mode(): string;

    /** Price a stay. Throws \InvalidArgumentException when the dates or guests are not allowed. */
    public function quote(Stay $stay, CarbonImmutable $checkIn, CarbonImmutable $checkOut, int $guests): StayQuote;

    /**
     * true / false when the provider knows, null when it must be confirmed by a person.
     */
    public function isAvailable(Stay $stay, CarbonImmutable $checkIn, CarbonImmutable $checkOut): ?bool;

    /** Place the request or booking for a guest. */
    public function request(Stay $stay, StayQuote $quote, array $guest): BookingResult;
}
