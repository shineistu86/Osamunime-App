<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\JikanApiService;
use Illuminate\Support\Facades\Http;

class JikanApiServiceTest extends TestCase
{
    /** @test */
    public function it_can_fetch_top_anime()
    {
        // Mock HTTP response
        Http::fake([
            'https://api.jikan.moe/v4/top/anime?page=1' => Http::response([
                'data' => [
                    ['mal_id' => 1, 'title' => 'Test Anime']
                ],
                'pagination' => ['current_page' => 1]
            ], 200)
        ]);

        $service = new JikanApiService(false);
        $result = $service->getTopAnime(1);

        // Assert the result structure
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('pagination', $result);
        $this->assertCount(1, $result['data']);
        $this->assertEquals('Test Anime', $result['data'][0]['title']);
    }

    /** @test */
    public function it_can_fetch_anime_by_id()
    {
        // Mock HTTP response
        Http::fake([
            'https://api.jikan.moe/v4/anime/1' => Http::response([
                'data' => [
                    'mal_id' => 1,
                    'title' => 'Test Anime',
                    'score' => 8.5
                ]
            ], 200)
        ]);

        $service = new JikanApiService(false);
        $result = $service->getAnimeById(1);

        // Assert the result
        $this->assertNotNull($result);
        $this->assertEquals(1, $result['mal_id']);
        $this->assertEquals('Test Anime', $result['title']);
    }

    /** @test */
    public function it_handles_api_errors_gracefully()
    {
        // Mock HTTP error response
        Http::fake([
            'https://api.jikan.moe/v4/top/anime?page=999' => Http::response([], 500)
        ]);

        $service = new JikanApiService(false);
        $result = $service->getTopAnime(999);

        // Assert that it returns empty arrays on error
        $this->assertIsArray($result);
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('pagination', $result);
        $this->assertEmpty($result['data']);
    }

    /** @test */
    public function it_can_search_anime()
    {
        // Mock HTTP response
        Http::fake([
            'https://api.jikan.moe/v4/anime?q=test&page=1' => Http::response([
                'data' => [
                    ['mal_id' => 1, 'title' => 'Test Anime']
                ],
                'pagination' => ['current_page' => 1]
            ], 200)
        ]);

        $service = new JikanApiService(false);
        $result = $service->searchAnime('test', 1);

        // Assert the result structure
        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('pagination', $result);
        $this->assertCount(1, $result['data']);
        $this->assertEquals('Test Anime', $result['data'][0]['title']);
    }
}