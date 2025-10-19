<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\CalendarEvent;

class AdminEventTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_event()
    {
        $this->withSession(['is_admin' => true]);

        $response = $this->post(route('admin.events.store'), [
            'month' => 'April',
            'title' => 'Event Test',
        ]);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('calendar_events', ['title' => 'Event Test']);
    }
}
