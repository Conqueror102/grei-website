<?php

namespace App\Http\Controllers;

use App\Contracts\StayBookingProvider;
use App\Models\Stay;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use InvalidArgumentException;

class StayController extends Controller
{
    public function __construct(private StayBookingProvider $booking) {}

    public function index(Request $request)
    {
        $search = $request->validate([
            'city' => ['nullable', 'string', 'max:60'],
            'check_in' => ['nullable', 'date', 'after_or_equal:today'],
            'check_out' => ['nullable', 'date', 'after:check_in'],
            'guests' => ['nullable', 'integer', 'min:1', 'max:20'],
        ]);

        $stays = Stay::ordered()
            ->when($search['city'] ?? null, fn ($q, $v) => $q->where('city', $v))
            ->when($search['guests'] ?? null, fn ($q, $v) => $q->where('max_guests', '>=', $v))
            ->get();

        // Drop stays the provider knows are unavailable (request mode knows nothing, so keeps all).
        if (! empty($search['check_in']) && ! empty($search['check_out'])) {
            $in = CarbonImmutable::parse($search['check_in']);
            $out = CarbonImmutable::parse($search['check_out']);
            $stays = $stays->reject(fn (Stay $s) => $this->booking->isAvailable($s, $in, $out) === false)->values();
        }

        return view('stays.index', [
            'stays' => $stays,
            'search' => $search,
            'cities' => Stay::query()->distinct()->orderBy('city')->pluck('city'),
            'mode' => $this->booking->mode(),
        ]);
    }

    public function show(Stay $stay)
    {
        return view('stays.show', [
            'stay' => $stay,
            'mode' => $this->booking->mode(),
            'others' => Stay::ordered()->whereKeyNot($stay->id)->take(2)->get(),
        ]);
    }

    public function request(Request $request, Stay $stay)
    {
        if ($request->filled('website')) { // honeypot
            return back()->with('enquiry_sent', true);
        }

        $data = $request->validate([
            'check_in' => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests' => ['required', 'integer', 'min:1', 'max:'.$stay->max_guests],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'purpose' => ['nullable', 'in:business,leisure,relocation'],
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        try {
            $quote = $this->booking->quote(
                $stay,
                CarbonImmutable::parse($data['check_in']),
                CarbonImmutable::parse($data['check_out']),
                (int) $data['guests'],
            );
        } catch (InvalidArgumentException $e) {
            return back()->withInput()->withErrors(['check_out' => $e->getMessage()]);
        }

        $result = $this->booking->request($stay, $quote, $data);

        if ($result->paymentUrl) {
            return redirect()->away($result->paymentUrl);
        }

        return redirect()->route('stays.show', $stay)
            ->with('stay_requested', ['reference' => $result->reference] + $quote->toArray());
    }
}
