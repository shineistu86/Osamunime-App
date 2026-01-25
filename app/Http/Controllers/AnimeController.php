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
        $animes = $this->jikanApiService->getTopAnime($page);

        if (empty($animes)) {
            \Log::warning('No anime data retrieved from API');
            // Optionally show a warning message to the user
            session()->flash('warning', 'Could not load anime data. Please try again later.');
        }

        return view('anime.index', compact('animes'));
    }

    /**
     * Search for anime by keyword.
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q', '');
        $page = $request->input('page', 1);

        if (!empty($keyword)) {
            $animes = $this->jikanApiService->searchAnime($keyword, $page);
            if (empty($animes)) {
                \Log::warning('No anime found for search term: ' . $keyword);
                session()->flash('warning', 'No anime found for your search term. Please try a different keyword.');
            }
        } else {
            $animes = $this->jikanApiService->getTopAnime($page);
            if (empty($animes)) {
                \Log::warning('No anime data retrieved from API');
                session()->flash('warning', 'Could not load anime data. Please try again later.');
            }
        }

        return view('anime.search', compact('animes', 'keyword'));
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
