<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class JikanApiService
{
    protected string $baseUrl;
    protected bool $useCache = true;

    public function __construct(bool $useCache = true)
    {
        $this->baseUrl = config('services.jikan.base_url', env('JIKAN_API_BASE_URL', 'https://api.jikan.moe/v4'));
        $this->useCache = $useCache;
    }

    /**
     * Get top anime from Jikan API
     *
     * @param int $page
     * @return array
     */
    public function getTopAnime(int $page = 1): array
    {
        if ($this->useCache) {
            $cacheKey = "jikan_top_anime_page_{$page}";
            $cacheTime = 30; // Cache for 30 minutes

            return Cache::remember($cacheKey, $cacheTime * 60, function() use ($page) {
                return $this->fetchTopAnime($page);
            });
        } else {
            return $this->fetchTopAnime($page);
        }
    }

    /**
     * Internal method to fetch top anime without cache
     *
     * @param int $page
     * @return array
     */
    private function fetchTopAnime(int $page): array
    {
        try {
            $response = Http::timeout(30)->get("{$this->baseUrl}/top/anime", [
                'page' => $page,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'data' => $data['data'] ?? [],
                    'pagination' => $data['pagination'] ?? null
                ];
            } else {
                \Log::error('Jikan API Error - getTopAnime', [
                    'status' => $response->status(),
                    'message' => $response->body()
                ]);
                return [
                    'data' => [],
                    'pagination' => null
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Jikan API Exception - getTopAnime', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'data' => [],
                'pagination' => null
            ];
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
        if ($this->useCache) {
            $cacheKey = "jikan_search_" . md5($keyword) . "_page_{$page}";
            $cacheTime = 30; // Cache for 30 minutes

            return Cache::remember($cacheKey, $cacheTime * 60, function() use ($keyword, $page) {
                return $this->fetchSearchAnime($keyword, $page);
            });
        } else {
            return $this->fetchSearchAnime($keyword, $page);
        }
    }

    /**
     * Internal method to search anime without cache
     *
     * @param string $keyword
     * @param int $page
     * @return array
     */
    private function fetchSearchAnime(string $keyword, int $page): array
    {
        try {
            $params = [
                'page' => $page,
            ];

            // Only add the query parameter if keyword is not empty
            if (!empty($keyword)) {
                $params['q'] = $keyword;
            }

            $response = Http::timeout(30)->get("{$this->baseUrl}/anime", $params);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'data' => $data['data'] ?? [],
                    'pagination' => $data['pagination'] ?? null
                ];
            } else {
                \Log::error('Jikan API Error - searchAnime', [
                    'status' => $response->status(),
                    'message' => $response->body(),
                    'keyword' => $keyword
                ]);
                return [
                    'data' => [],
                    'pagination' => null
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Jikan API Exception - searchAnime', [
                'error' => $e->getMessage(),
                'keyword' => $keyword,
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'data' => [],
                'pagination' => null
            ];
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
        if ($this->useCache) {
            $cacheKey = "jikan_anime_{$id}";
            $cacheTime = 60; // Cache for 60 minutes

            return Cache::remember($cacheKey, $cacheTime * 60, function() use ($id) {
                return $this->fetchAnimeById($id);
            });
        } else {
            return $this->fetchAnimeById($id);
        }
    }

    /**
     * Internal method to fetch anime by ID without cache
     *
     * @param int $id
     * @return array|null
     */
    private function fetchAnimeById(int $id): ?array
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

    /**
     * Get anime by genre from Jikan API
     *
     * @param int $genreId
     * @param int $page
     * @return array
     */
    public function getAnimeByGenre(int $genreId, int $page = 1): array
    {
        if ($this->useCache) {
            $cacheKey = "jikan_genre_{$genreId}_page_{$page}";
            $cacheTime = 30; // Cache for 30 minutes

            return Cache::remember($cacheKey, $cacheTime * 60, function() use ($genreId, $page) {
                return $this->fetchAnimeByGenre($genreId, $page);
            });
        } else {
            return $this->fetchAnimeByGenre($genreId, $page);
        }
    }

    /**
     * Internal method to fetch anime by genre without cache
     *
     * @param int $genreId
     * @param int $page
     * @return array
     */
    private function fetchAnimeByGenre(int $genreId, int $page): array
    {
        try {
            $response = Http::timeout(30)->get("{$this->baseUrl}/anime", [
                'genre' => $genreId,
                'page' => $page,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'data' => $data['data'] ?? [],
                    'pagination' => $data['pagination'] ?? null
                ];
            } else {
                \Log::error('Jikan API Error - getAnimeByGenre', [
                    'status' => $response->status(),
                    'message' => $response->body(),
                    'genreId' => $genreId
                ]);
                return [
                    'data' => [],
                    'pagination' => null
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Jikan API Exception - getAnimeByGenre', [
                'error' => $e->getMessage(),
                'genreId' => $genreId,
                'trace' => $e->getTraceAsString()
            ]);
            return [
                'data' => [],
                'pagination' => null
            ];
        }
    }
}