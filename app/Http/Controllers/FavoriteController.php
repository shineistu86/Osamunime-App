<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Http\Requests\StoreFavoriteRequest;
use App\Http\Requests\UpdateFavoriteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    //

    /**
     * Menampilkan daftar anime favorit
     */
    public function index(Request $request)
    {
        $query = Auth::user()->favorites()->with('user', 'tags');

        // Menangani filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->tag . '%');
            });
        }

        // Menangani pengurutan
        $sortBy = $request->get('sort_by', 'created_at'); // Urutkan berdasarkan tanggal dibuat secara default
        $sortOrder = $request->get('sort_order', 'desc'); // Urutan menurun secara default

        $validSortColumns = ['title', 'score', 'rating', 'status', 'created_at'];
        if (in_array($sortBy, $validSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $favorites = $query->paginate(12)->appends(request()->query());

        // Dapatkan tag unik untuk dropdown filter
        $allTags = Auth::user()->favorites()->with('tags')->get()->pluck('tags')->flatten()->unique('id')->sortBy('name');

        return view('favorites.index', compact('favorites', 'allTags'));
    }

    /**
     * Menampilkan form untuk membuat data baru
     */
    public function create()
    {
        //
    }

    /**
     * Menyimpan data baru ke dalam penyimpanan
     */
    public function store(StoreFavoriteRequest $request)
    {
        $favorite = new Favorite();
        $favorite->user_id = Auth::id();
        $favorite->anime_id = $request->anime_id;
        $favorite->title = $request->title;
        $favorite->image_url = $request->image_url;
        $favorite->score = $request->score ?? null;
        $favorite->rating = $request->rating ?? null;
        $favorite->review = $request->review ?? null;
        $favorite->status = $request->status;
        $favorite->notes = $request->notes ?? null;
        $favorite->save();

        // Menangani tag jika disediakan
        if ($request->has('tags')) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    $tag = \App\Models\Tag::firstOrCreate(
                        ['slug' => strtolower(str_replace(' ', '-', $tagName))],
                        ['name' => $tagName]
                    );
                    $tagIds[] = $tag->id;
                }
            }

            $favorite->tags()->attach($tagIds);
        }

        return redirect()->route('favorites.index')->with('success', 'Anime ditambahkan ke favorit berhasil!');
    }

    /**
     * Menampilkan detail anime favorit
     */
    public function show($id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);
        return view('favorites.show', compact('favorite'));
    }

    /**
     * Menampilkan form untuk mengedit anime favorit
     */
    public function edit($id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);
        return view('favorites.edit', compact('favorite'));
    }

    /**
     * Memperbarui data anime favorit di dalam penyimpanan
     */
    public function update(UpdateFavoriteRequest $request, $id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);

        $favorite->update([
            'score' => $request->score ?? null,
            'rating' => $request->rating ?? null,
            'review' => $request->review ?? null,
            'status' => $request->status,
            'notes' => $request->notes ?? null
        ]);

        // Menangani tag jika disediakan
        if ($request->has('tags')) {
            $tagNames = explode(',', $request->tags);
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    $tag = \App\Models\Tag::firstOrCreate(
                        ['slug' => strtolower(str_replace(' ', '-', $tagName))],
                        ['name' => $tagName]
                    );
                    $tagIds[] = $tag->id;
                }
            }

            $favorite->tags()->sync($tagIds);
        }

        return redirect()->route('favorites.index')->with('success', 'Favorit diperbarui berhasil!');
    }

    /**
     * Menghapus anime favorit dari penyimpanan
     */
    public function destroy($id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);
        $favorite->delete();

        return redirect()->route('favorites.index')->with('success', 'Favorit dihapus berhasil!');
    }

    /**
     * Mengaktifkan/nonaktifkan status favorit untuk sebuah anime
     */
    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'anime_id' => 'required|integer',
            'title' => 'required|string|max:255',
            'image_url' => 'required|url',
            'score' => 'nullable|numeric|min:0|max:10',
        ]);

        $existingFavorite = Auth::user()->favorites()
            ->where('anime_id', $request->anime_id)
            ->first();

        if ($existingFavorite) {
            $existingFavorite->delete();
            return response()->json(['status' => 'removed', 'message' => 'Dihapus dari favorit']);
        } else {
            $favorite = new Favorite();
            $favorite->user_id = Auth::id();
            $favorite->anime_id = $request->anime_id;
            $favorite->title = $request->title;
            $favorite->image_url = $request->image_url;
            $favorite->score = $request->score ?? null;
            $favorite->status = 'Plan to Watch'; // Status default
            $favorite->save();

            return response()->json(['status' => 'added', 'message' => 'Ditambahkan ke favorit']);
        }
    }
}
