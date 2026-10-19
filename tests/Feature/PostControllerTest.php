<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase; // Reset database tiap test[cite: 7]
use App\Models\User;
use App\Models\Post;

class PostControllerTest extends TestCase
{
    use RefreshDatabase; // Menggunakan SQLite in-memory agar cepat & terisolasi[cite: 7]

    // 1. Menguji Halaman (GET) oleh Guest[cite: 7]
    public function test_guest_can_view_posts()
    {
        Post::factory()->count(3)->create();

        $response = $this->get('/posts');

        // Assertion status HTTP sukses[cite: 9]
        $response->assertStatus(200); 
    }

    // 2. Menguji Pengiriman Data (POST) oleh User Login[cite: 7]
    public function test_user_can_create_post()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/posts', [
            'title' => 'Judul'
        ]);

        // Assertion redirect dan keberadaan data di database[cite: 7, 9]
        $response->assertRedirect('/posts');
        $this->assertDatabaseHas('posts', [
            'title' => 'Judul'
        ]);
    }
}