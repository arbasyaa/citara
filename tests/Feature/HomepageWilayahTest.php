<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Wilayah;

class HomepageWilayahTest extends TestCase
{
    use RefreshDatabase;

    public function test_newly_created_wilayah_appears_on_homepage()
    {
        // Create table schema via migrations
        $this->artisan('migrate')->run();

        $wilayah = Wilayah::create([
            'nama' => 'Wilayah Test Home',
            'deskripsi' => 'Deskripsi test',
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSeeText('Wilayah Test Home');
    }
}
