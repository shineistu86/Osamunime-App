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
        try {
            $response = Http::timeout(30)->get("{$this->baseUrl}/top/anime", [
                'page' => $page,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? [];
            } else {
                \Log::error('Jikan API Error - getTopAnime', [
                    'status' => $response->status(),
                    'message' => $response->body()
                ]);
                return [];
            }
        } catch (\Exception $e) {
            \Log::error('Jikan API Exception - getTopAnime', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
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
        try {
            $response = Http::timeout(30)->get("{$this->baseUrl}/anime", [
                'q' => $keyword,
                'page' => $page,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? [];
            } else {
                \Log::error('Jikan API Error - searchAnime', [
                    'status' => $response->status(),
                    'message' => $response->body(),
                    'keyword' => $keyword
                ]);
                return [];
            }
        } catch (\Exception $e) {
            \Log::error('Jikan API Exception - searchAnime', [
                'error' => $e->getMessage(),
                'keyword' => $keyword,
                'trace' => $e->getTraceAsString()
            ]);
            return [];
        }
    }

    /**
     * Get anime details by ID from Jikan API
     *
     * @param int $id
     * @return array|null
     */
    public function getAnimeById(int $id): ?array
    {
        try {
            $response = Http::timeout(30)->get("{$this->baseUrl}/anime/{$id}");

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? null;
            } else {
                \Log::error('Jikan API Error - getAnimeById', [
                    'status' => $response->status(),
                    'message' => $response->body(),
                    'id' => $id
                ]);
                return null;
            }
        } catch (\Exception $e) {
            \Log::error('Jikan API Exception - getAnimeById', [
                'error' => $e->getMessage(),
                'id' => $id,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }
}