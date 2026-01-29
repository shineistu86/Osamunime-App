<?php

namespace App\Http\Controllers;

use App\Services\JikanApiService;
use Illuminate\Http\Request;

class AnimeController extends Controller
{
    protected JikanApiService $jikanApiService;

    public function __construct(JikanApiService $jikanApiService)
    {
        $this->jikanApiService = $jikanApiService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->input('page', 1);
        $response = $this->jikanApiService->getTopAnime($page);
        $animes = $response['data'] ?? [];
        $pagination = $response['pagination'];

        if (empty($animes)) {
            \Log::warning('No anime data retrieved from API');
            // Optionally show a warning message to the user
            session()->flash('warning', 'Could not load anime data. Please try again later.');
        }

        return view('anime.index', compact('animes', 'pagination'));
    }

    /**
     * Display popular anime.
     */
    public function popular(Request $request)
    {
        $page = $request->input('page', 1);
        $response = $this->jikanApiService->getTopAnime($page);
        $animes = $response['data'] ?? [];
        $pagination = $response['pagination'];

        if (empty($animes)) {
            \Log::warning('No anime data retrieved from API');
            session()->flash('warning', 'Could not load anime data. Please try again later.');
        }

        return view('anime.popular', compact('animes', 'pagination'));
    }

    /**
     * Display all anime with pagination.
     */
    public function all(Request $request)
    {
        $page = $request->input('page', 1);

        // Using Jikan API to get all anime (using empty search to get all)
        $response = $this->jikanApiService->searchAnime('', $page);
        $animes = $response['data'] ?? [];
        $pagination = $response['pagination'];

        if (empty($animes)) {
            \Log::warning('No anime data retrieved from API');
            session()->flash('warning', 'Could not load anime data. Please try again later.');
        }

        return view('anime.all', compact('animes', 'pagination'));
    }

    /**
     * Search for anime by keyword.
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');
        $page = $request->input('page', 1);

        if (!empty($keyword)) {
            $response = $this->jikanApiService->searchAnime($keyword, $page);
            $animes = $response['data'] ?? [];
            $pagination = $response['pagination'];

            if (empty($animes)) {
                \Log::warning('No anime found for search term: ' . $keyword);
                session()->flash('warning', 'No anime found for your search term. Please try a different keyword.');
            }
        } else {
            $response = $this->jikanApiService->getTopAnime($page);
            $animes = $response['data'] ?? [];
            $pagination = $response['pagination'];

            if (empty($animes)) {
                \Log::warning('No anime data retrieved from API');
                session()->flash('warning', 'Could not load anime data. Please try again later.');
            }
        }

        return view('anime.search', compact('animes', 'keyword', 'pagination'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $anime = $this->jikanApiService->getAnimeById($id);

        if (!$anime) {
            \Log::warning('Anime not found or could not be loaded from API: ' . $id);
            session()->flash('error', 'This anime could not be loaded. It may not exist or there was an issue retrieving it.');
            return redirect()->route('anime.index')->with('error', 'This anime could not be loaded. It may not exist or there was an issue retrieving it.');
        }

        return view('anime.show', compact('anime'));
    }

    /**
     * Display the list of genres.
     */
    public function genreList()
    {
        // Common anime genres based on Jikan API (excluding adult content)
        $genres = [
            ['id' => 1, 'name' => 'Action'],
            ['id' => 2, 'name' => 'Adventure'],
            ['id' => 5, 'name' => 'Avant Garde'],
            ['id' => 6, 'name' => 'Award Winning'],
            ['id' => 46, 'name' => 'Boys Love'],
            ['id' => 8, 'name' => 'Comedy'],
            ['id' => 10, 'name' => 'Drama'],
            ['id' => 11, 'name' => 'Fantasy'],
            ['id' => 47, 'name' => 'Girls Love'],
            ['id' => 12, 'name' => 'Horror'],
            ['id' => 7, 'name' => 'Mystery'],
            ['id' => 13, 'name' => 'Romance'],
            ['id' => 14, 'name' => 'Sci-Fi'],
            ['id' => 48, 'name' => 'Slice of Life'],
            ['id' => 15, 'name' => 'Sports'],
            ['id' => 16, 'name' => 'Supernatural'],
            ['id' => 49, 'name' => 'Suspense'],
            ['id' => 21, 'name' => 'Anthropomorphic'],
            ['id' => 22, 'name' => 'CGDCT'],
            ['id' => 23, 'name' => 'Childcare'],
            ['id' => 24, 'name' => 'Combat Sports'],
            ['id' => 25, 'name' => 'Crossdressing'],
            ['id' => 26, 'name' => 'Delinquents'],
            ['id' => 27, 'name' => 'Detective'],
            ['id' => 28, 'name' => 'Educational'],
            ['id' => 29, 'name' => 'Gag Humor'],
            ['id' => 30, 'name' => 'Gore'],
            ['id' => 31, 'name' => 'Harem'],
            ['id' => 32, 'name' => 'High Stakes Game'],
            ['id' => 33, 'name' => 'Historical'],
            ['id' => 34, 'name' => 'Idols Female'],
            ['id' => 35, 'name' => 'Idols Male'],
            ['id' => 36, 'name' => 'Isekai'],
            ['id' => 37, 'name' => 'Iyashikei'],
            ['id' => 38, 'name' => 'Love Polygon'],
            ['id' => 39, 'name' => 'Magical Sex Shift'],
            ['id' => 40, 'name' => 'Mahou Shoujo'],
            ['id' => 41, 'name' => 'Martial Arts'],
            ['id' => 42, 'name' => 'Mecha'],
            ['id' => 43, 'name' => 'Medical'],
            ['id' => 44, 'name' => 'Military'],
            ['id' => 45, 'name' => 'Music'],
        ];

        return view('anime.genres', compact('genres'));
    }

    /**
     * Display anime by genre.
     */
    public function byGenre($genreId)
    {
        $page = request()->input('page', 1);

        // Fetch anime by genre from the API
        $response = $this->jikanApiService->getAnimeByGenre($genreId, $page);
        $animes = $response['data'] ?? [];
        $pagination = $response['pagination'];

        // Find the genre name based on ID
        $availableGenres = [
            1 => 'Action',
            2 => 'Adventure',
            5 => 'Avant Garde',
            6 => 'Award Winning',
            46 => 'Boys Love',
            8 => 'Comedy',
            10 => 'Drama',
            11 => 'Fantasy',
            47 => 'Girls Love',
            12 => 'Horror',
            7 => 'Mystery',
            13 => 'Romance',
            14 => 'Sci-Fi',
            48 => 'Slice of Life',
            15 => 'Sports',
            16 => 'Supernatural',
            49 => 'Suspense',
            21 => 'Anthropomorphic',
            22 => 'CGDCT',
            23 => 'Childcare',
            24 => 'Combat Sports',
            25 => 'Crossdressing',
            26 => 'Delinquents',
            27 => 'Detective',
            28 => 'Educational',
            29 => 'Gag Humor',
            30 => 'Gore',
            31 => 'Harem',
            32 => 'High Stakes Game',
            33 => 'Historical',
            34 => 'Idols Female',
            35 => 'Idols Male',
            36 => 'Isekai',
            37 => 'Iyashikei',
            38 => 'Love Polygon',
            39 => 'Magical Sex Shift',
            40 => 'Mahou Shoujo',
            41 => 'Martial Arts',
            42 => 'Mecha',
            43 => 'Medical',
            44 => 'Military',
            45 => 'Music',
        ];

        $genreName = $availableGenres[$genreId] ?? 'Unknown Genre';

        return view('anime.by-genre', compact('animes', 'pagination', 'genreName', 'genreId'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
