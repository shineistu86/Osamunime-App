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
        } else {
            $animes = $this->jikanApiService->getTopAnime($page);
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
            abort(404, 'Anime not found');
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
