<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_reservation_form()
    {
        $event = Event::factory()->create();

        $response = $this->get("/events/{$event->id}/reservations/create");

        $response->assertStatus(200);
        $response->assertViewIs('reservations.create');
        $response->assertViewHas('event');
    }

    public function test_user_can_make_a_reservation()
    {
        $event = Event::factory()->create();

        $response = $this->post("/events/{$event->id}/reservations", [
            'name' => 'Taro Yamada',
            'email' => 'taro@example.com',
            'number_of_people' => 2,
            'reserved_at' => now()->addDays(3)->format('Y-m-d H:i:s'),
        ]);

        $response->assertRedirect('/reservations');
        $this->assertDatabaseHas('reservations', [
            'event_id' => $event->id,
            'name' => 'Taro Yamada',
        ]);
    }

    public function test_user_can_view_reservation_list()
    {
        Reservation::factory()->count(3)->create();

        $response = $this->get('/reservations');

        $response->assertStatus(200);
        $response->assertViewIs('reservations.index');
        $response->assertViewHas('reservations');
    }

    public function test_user_can_cancel_a_reservation()
    {
        $reservation = Reservation::factory()->create();

        $response = $this->delete("/reservations/{$reservation->id}");

        $response->assertRedirect('/reservations');
        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }

    public function test_cancelling_nonexistent_reservation_returns_404()
    {
        $response = $this->delete('/reservations/9999');

        $response->assertStatus(404);
    }
}