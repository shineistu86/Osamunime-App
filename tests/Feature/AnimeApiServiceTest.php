<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnimeApiServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the home page loads correctly
     */
    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test the anime index page loads correctly
     */
    public function test_anime_index_page_loads_successfully(): void
    {
        $response = $this->get('/anime');

        $response->assertStatus(200);
    }

    /**
     * Test the search page loads correctly
     */
    public function test_anime_search_page_loads_successfully(): void
    {
        $response = $this->get('/anime/search');

        $response->assertStatus(200);
    }

    /**
     * Test authentication routes
     */
    public function test_login_page_loads(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test registration page loads
     */
    public function test_registration_page_loads(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * Test that guest users are redirected from favorites page
     */
    public function test_guest_user_is_redirected_from_favorites(): void
    {
        $response = $this->get('/favorites');

        $response->assertRedirect('/login');
    }

    /**
     * Test authenticated user can access favorites
     */
    public function test_authenticated_user_can_access_favorites(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/favorites');

        $response->assertStatus(200);
    }

    /**
     * Test creating a favorite
     */
    public function test_user_can_create_favorite(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/favorites', [
                'anime_id' => 1,
                'title' => 'Test Anime',
                'image_url' => 'https://example.com/image.jpg',
                'score' => 8.5,
                'status' => 'Plan to Watch',
                'notes' => 'Test notes'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'anime_id' => 1,
            'title' => 'Test Anime',
        ]);
    }

    /**
     * Test updating a favorite
     */
    public function test_user_can_update_favorite(): void
    {
        $user = User::factory()->create();
        $favorite = Favorite::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->put("/favorites/{$favorite->id}", [
                'score' => 9.0,
                'status' => 'Watching',
                'notes' => 'Updated notes'
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('favorites', [
            'id' => $favorite->id,
            'score' => 9.0,
            'status' => 'Watching',
            'notes' => 'Updated notes'
        ]);
    }

    /**
     * Test deleting a favorite
     */
    public function test_user_can_delete_favorite(): void
    {
        $user = User::factory()->create();
        $favorite = Favorite::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->delete("/favorites/{$favorite->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('favorites', [
            'id' => $favorite->id
        ]);
    }
}
