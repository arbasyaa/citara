<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WilayahControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index_displays_wilayah_list(): void
    {
        $wilayah = Wilayah::create([
            'nama' => 'Wilayah Test',
            'slug' => 'wilayah-test',
            'deskripsi' => 'Deskripsi wilayah test'
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('admin.wilayah.index'));

        $response->assertStatus(200)
            ->assertViewIs('admin.wilayah.index')
            ->assertSee($wilayah->nama);
    }

    public function test_store_creates_new_wilayah(): void
    {
        $wilayahData = [
            'nama' => 'Wilayah Baru',
            'deskripsi' => 'Deskripsi wilayah baru'
        ];

        $response = $this->actingAs($this->user)
            ->post(route('admin.wilayah.store'), $wilayahData);

        $response->assertRedirect(route('admin.wilayah.index'));
        $this->assertDatabaseHas('wilayah', [
            'nama' => 'Wilayah Baru',
            'slug' => 'wilayah-baru'
        ]);
    }

    public function test_update_modifies_wilayah(): void
    {
        $wilayah = Wilayah::create([
            'nama' => 'Wilayah Lama',
            'slug' => 'wilayah-lama',
            'deskripsi' => 'Deskripsi lama'
        ]);

        $updatedData = [
            'nama' => 'Wilayah Updated',
            'deskripsi' => 'Deskripsi updated'
        ];

        $response = $this->actingAs($this->user)
            ->put(route('admin.wilayah.update', $wilayah), $updatedData);

        $response->assertRedirect(route('admin.wilayah.index'));
        $this->assertDatabaseHas('wilayah', [
            'id' => $wilayah->id,
            'nama' => 'Wilayah Updated',
            'slug' => 'wilayah-updated'
        ]);
    }

    public function test_destroy_removes_wilayah(): void
    {
        $wilayah = Wilayah::create([
            'nama' => 'Wilayah Delete',
            'slug' => 'wilayah-delete',
            'deskripsi' => 'Deskripsi delete'
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('admin.wilayah.destroy', $wilayah));

        $response->assertRedirect(route('admin.wilayah.index'));
        $this->assertDatabaseMissing('wilayah', ['id' => $wilayah->id]);
    }
}
