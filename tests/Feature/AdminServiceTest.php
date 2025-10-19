<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Service;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_service()
    {
        // set admin session
        $this->withSession(['is_admin' => true]);

        $response = $this->post(route('admin.services.store'), [
            'title' => 'Test Service',
            'description' => 'Desc',
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['title' => 'Test Service']);
    }
}
