<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class JikanApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.jikan.base_url', env('JIKAN_API_BASE_URL', 'https://api.jikan.moe/v4'));
    }

    /**
     * Get top anime from Jikan API
     *
     * @param int $page
     * @return array
     */
    public function getTopAnime(int $page = 1): array
    {
        $response = Http::get("{$this->baseUrl}/top/anime", [
            'page' => $page,
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return [];
    }

    /**
     * Search anime by keyword from Jikan API
     *
     * @param string $keyword
     * @param int $page
     * @return array
     */
    public function searchAnime(string $keyword, int $page = 1): array
    {
        $response = Http::get("{$this->baseUrl}/anime", [
            'q' => $keyword,
            'page' => $page,
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return [];
    }

    /**
     * Get anime details by ID from Jikan API
     *
     * @param int $id
     * @return array|null
     */
    public function getAnimeById(int $id): ?array
    {
        $response = Http::get("{$this->baseUrl}/anime/{$id}");

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return null;
    }
}