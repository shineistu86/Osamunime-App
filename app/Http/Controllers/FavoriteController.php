<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    //

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->favorites()->with('user', 'tags');

        // Handle filtering
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

        // Handle sorting
        $sortBy = $request->get('sort_by', 'created_at'); // Default sort by creation date
        $sortOrder = $request->get('sort_order', 'desc'); // Default sort order descending

        $validSortColumns = ['title', 'score', 'rating', 'status', 'created_at'];
        if (in_array($sortBy, $validSortColumns)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $favorites = $query->paginate(12)->appends(request()->query());

        // Get unique tags for filter dropdown
        $allTags = Auth::user()->favorites()->with('tags')->get()->pluck('tags')->flatten()->unique('id')->sortBy('name');

        return view('favorites.index', compact('favorites', 'allTags'));
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
        $request->validate([
            'anime_id' => 'required|integer|unique:favorites,anime_id,NULL,id,user_id,' . Auth::id(),
            'title' => 'required|string|max:255',
            'image_url' => 'required|url',
            'score' => 'nullable|numeric|min:0|max:10',
            'rating' => 'nullable|integer|min:1|max:10',
            'review' => 'nullable|string',
            'status' => 'required|in:Watching,Completed,Plan to Watch',
            'notes' => 'nullable|string'
        ]);

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

        // Handle tags if provided
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

        return redirect()->route('favorites.index')->with('success', 'Anime added to favorites successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);
        return view('favorites.show', compact('favorite'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);
        return view('favorites.edit', compact('favorite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);

        $request->validate([
            'score' => 'nullable|numeric|min:0|max:10',
            'rating' => 'nullable|integer|min:1|max:10',
            'review' => 'nullable|string',
            'status' => 'required|in:Watching,Completed,Plan to Watch',
            'notes' => 'nullable|string'
        ]);

        $favorite->update([
            'score' => $request->score ?? null,
            'rating' => $request->rating ?? null,
            'review' => $request->review ?? null,
            'status' => $request->status,
            'notes' => $request->notes ?? null
        ]);

        // Handle tags if provided
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

        return redirect()->route('favorites.index')->with('success', 'Favorite updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $favorite = Auth::user()->favorites()->findOrFail($id);
        $favorite->delete();

        return redirect()->route('favorites.index')->with('success', 'Favorite removed successfully!');
    }

    /**
     * Toggle favorite status for an anime
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
            return response()->json(['status' => 'removed', 'message' => 'Removed from favorites']);
        } else {
            $favorite = new Favorite();
            $favorite->user_id = Auth::id();
            $favorite->anime_id = $request->anime_id;
            $favorite->title = $request->title;
            $favorite->image_url = $request->image_url;
            $favorite->score = $request->score ?? null;
            $favorite->status = 'Plan to Watch'; // Default status
            $favorite->save();

            return response()->json(['status' => 'added', 'message' => 'Added to favorites']);
        }
    }
}
