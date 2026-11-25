<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\Property;
use App\Models\Stay;
use App\Notifications\NewEnquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SiteTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_every_page_renders(): void
    {
        foreach (['/', '/about', '/contact', '/real-estate', '/interiors', '/stays',
            '/real-estate/the-meridian-residence', '/interiors/projects/ikoyi-family-residence', '/stays/the-gold-suite'] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_property_filters_narrow_results(): void
    {
        $this->get('/real-estate?category=commercial')
            ->assertSee('The Atrium Office Floors')
            ->assertDontSee('The Meridian Residence');
    }

    public function test_stay_search_respects_guest_count(): void
    {
        $this->get('/stays?guests=6')->assertSee('The Garden Villa')->assertDontSee('Studio Noir');
    }

    public function test_property_viewing_request_is_stored_and_sent(): void
    {
        Notification::fake();
        $property = Property::firstWhere('slug', 'the-meridian-residence');

        $this->from('/real-estate/'.$property->slug)->post('/enquiries', [
            'type' => 'property', 'subject_id' => $property->id, 'topic' => 'Viewing',
            'name' => 'Ada Test', 'email' => 'ada@example.com', 'message' => 'Next week please',
        ])->assertRedirect('/real-estate/'.$property->slug)->assertSessionHas('enquiry_sent');

        $enquiry = Enquiry::sole();
        $this->assertTrue($enquiry->subject->is($property));
        Notification::assertSentOnDemand(NewEnquiry::class);
    }

    public function test_stay_request_records_dates_and_quote(): void
    {
        Notification::fake();
        $stay = Stay::firstWhere('slug', 'the-gold-suite'); // 320/night, min 2

        $this->post("/stays/{$stay->slug}/request", [
            'check_in' => now()->addDays(10)->toDateString(),
            'check_out' => now()->addDays(13)->toDateString(),
            'guests' => 2, 'purpose' => 'business',
            'name' => 'Ada Test', 'email' => 'ada@example.com',
        ])->assertRedirect("/stays/{$stay->slug}")->assertSessionHas('stay_requested');

        $meta = Enquiry::sole()->meta;
        $this->assertSame(3, $meta['nights']);
        $this->assertSame(960, $meta['estimated_total']);
    }

    public function test_stay_request_enforces_minimum_nights_and_capacity(): void
    {
        $stay = Stay::firstWhere('slug', 'the-gold-suite');
        $base = ['name' => 'Ada', 'email' => 'ada@example.com', 'guests' => 2,
            'check_in' => now()->addDays(10)->toDateString()];

        $this->post("/stays/{$stay->slug}/request", $base + ['check_out' => now()->addDays(11)->toDateString()])
            ->assertSessionHasErrors('check_out');
        $this->post("/stays/{$stay->slug}/request", ['guests' => 5] + $base + ['check_out' => now()->addDays(13)->toDateString()])
            ->assertSessionHasErrors('guests');
        $this->assertSame(0, Enquiry::count());
    }

    public function test_honeypot_submissions_are_dropped(): void
    {
        $this->post('/enquiries', ['type' => 'general', 'name' => 'Bot', 'email' => 'b@x.com', 'message' => 'spam', 'website' => 'http://spam'])
            ->assertSessionHas('enquiry_sent');
        $this->assertSame(0, Enquiry::count());
    }
}
