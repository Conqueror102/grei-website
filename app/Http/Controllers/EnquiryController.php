<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Project;
use App\Models\Property;
use App\Notifications\NewEnquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class EnquiryController extends Controller
{
    private const SUBJECTS = ['property' => Property::class, 'interior' => Project::class];

    public function store(Request $request)
    {
        if ($request->filled('website')) { // honeypot
            return back()->with('enquiry_sent', true);
        }

        $data = $request->validate([
            'type' => ['required', 'in:general,property,interior'],
            'subject_id' => ['nullable', 'integer'],
            'topic' => ['nullable', 'string', 'max:120'],
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'budget' => ['nullable', 'string', 'max:60'],
            'property_type' => ['nullable', 'string', 'max:60'],
            'timeline' => ['nullable', 'string', 'max:60'],
            'preferred_date' => ['nullable', 'date', 'after_or_equal:today'],
            'format' => ['nullable', 'string', 'max:40'],
            'location' => ['nullable', 'string', 'max:120'],
            'interests' => ['nullable', 'array', 'max:6'],
            'interests.*' => ['string', 'max:40'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        $subject = null;
        if (($data['subject_id'] ?? null) && isset(self::SUBJECTS[$data['type']])) {
            $subject = self::SUBJECTS[$data['type']]::find($data['subject_id']);
        }

        $enquiry = Enquiry::create([
            'type' => $data['type'],
            'subject_type' => $subject?->getMorphClass(),
            'subject_id' => $subject?->getKey(),
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'topic' => $data['topic'] ?? ($subject->title ?? null),
            'message' => $data['message'],
            'meta' => array_filter([
                'budget' => $data['budget'] ?? null,
                'property_type' => $data['property_type'] ?? null,
                'timeline' => $data['timeline'] ?? null,
                'preferred_date' => $data['preferred_date'] ?? null,
                'format' => $data['format'] ?? null,
                'location' => $data['location'] ?? null,
                'interests' => isset($data['interests']) ? implode(', ', $data['interests']) : null,
            ]),
        ]);

        Notification::route('mail', config('grei.enquiries_to'))->notify(new NewEnquiry($enquiry));

        return back()->with('enquiry_sent', true);
    }
}
