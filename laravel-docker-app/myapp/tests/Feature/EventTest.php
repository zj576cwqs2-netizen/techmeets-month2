<?php

namespace Tests\Feature;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_event_list()
    {
        Event::factory()->count(3)->create();

        $response = $this->get('/events');

        $response->assertStatus(200);
        $response->assertViewIs('events.index');
        $response->assertViewHas('events');
    }

    public function test_user_can_view_a_single_event()
    {
        $event = Event::factory()->create();

        $response = $this->get("/events/{$event->id}");

        $response->assertStatus(200);
        $response->assertViewIs('events.show');
        $response->assertViewHas('event');
    }

    public function test_viewing_nonexistent_event_returns_404()
    {
        $response = $this->get('/events/9999');

        $response->assertStatus(404);
    }
}