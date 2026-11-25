<?php

namespace App\Services\Booking;

use App\Contracts\StayBookingProvider;
use App\Models\Enquiry;
use App\Models\Stay;
use App\Notifications\NewEnquiry;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Notification;
use InvalidArgumentException;

/** Stays by request: stores the request and notifies the GREI team. */
class EnquiryBookingProvider implements StayBookingProvider
{
    public function mode(): string
    {
        return 'request';
    }

    public function quote(Stay $stay, CarbonImmutable $checkIn, CarbonImmutable $checkOut, int $guests): StayQuote
    {
        $nights = (int) $checkIn->diffInDays($checkOut);

        if ($nights < 1) {
            throw new InvalidArgumentException('Check-out must be after check-in.');
        }
        if ($nights < $stay->min_nights) {
            throw new InvalidArgumentException("This residence has a minimum stay of {$stay->min_nights} nights.");
        }
        if ($guests > $stay->max_guests) {
            throw new InvalidArgumentException("This residence sleeps up to {$stay->max_guests} guests.");
        }

        return new StayQuote($checkIn, $checkOut, $guests, $nights, $stay->nightly_rate, $nights * $stay->nightly_rate);
    }

    public function isAvailable(Stay $stay, CarbonImmutable $checkIn, CarbonImmutable $checkOut): ?bool
    {
        return null; // confirmed by the team
    }

    public function request(Stay $stay, StayQuote $quote, array $guest): BookingResult
    {
        $enquiry = Enquiry::create([
            'type' => 'stay',
            'subject_type' => $stay->getMorphClass(),
            'subject_id' => $stay->getKey(),
            'name' => $guest['name'],
            'email' => $guest['email'],
            'phone' => $guest['phone'] ?? null,
            'topic' => 'Stay request: '.$stay->title,
            'message' => $guest['message'] ?? null,
            'meta' => $quote->toArray() + ['purpose' => $guest['purpose'] ?? null],
        ]);

        Notification::route('mail', config('grei.enquiries_to'))->notify(new NewEnquiry($enquiry));

        return new BookingResult('requested', 'GS-'.str_pad((string) $enquiry->id, 5, '0', STR_PAD_LEFT));
    }
}
