@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-danger text-white text-center py-3">
                    <h1 class="mb-0"><i class="fas fa-heart text-warning me-2"></i>{{ __('My Favorite Anime') }}</h1>
                    <p class="mb-0 opacity-75">Your personal collection of favorite anime</p>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Filters and Sorting -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('favorites.index') }}" class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
                                        <option value="">All Status</option>
                                        <option value="Plan to Watch" {{ request('status') === 'Plan to Watch' ? 'selected' : '' }}>Plan to Watch</option>
                                        <option value="Watching" {{ request('status') === 'Watching' ? 'selected' : '' }}>Watching</option>
                                        <option value="Completed" {{ request('status') === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <select name="rating" id="rating" class="form-select" onchange="this.form.submit()">
                                        <option value="">All Ratings</option>
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="tag" class="form-label">Tag</label>
                                    <select name="tag" id="tag" class="form-select" onchange="this.form.submit()">
                                        <option value="">All Tags</option>
                                        @foreach($allTags as $tag)
                                            <option value="{{ $tag->name }}" {{ request('tag') === $tag->name ? 'selected' : '' }}>
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="sort_by" class="form-label">Sort By</label>
                                    <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                                        <option value="created_at" {{ request('sort_by') === 'created_at' ? 'selected' : '' }}>Date Added</option>
                                        <option value="title" {{ request('sort_by') === 'title' ? 'selected' : '' }}>Title</option>
                                        <option value="score" {{ request('sort_by') === 'score' ? 'selected' : '' }}>Score</option>
                                        <option value="rating" {{ request('sort_by') === 'rating' ? 'selected' : '' }}>Rating</option>
                                        <option value="status" {{ request('sort_by') === 'status' ? 'selected' : '' }}>Status</option>
                                    </select>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <a href="{{ route('favorites.index') }}" class="btn btn-outline-secondary btn-sm">
                                        <i class="fas fa-times"></i> Clear Filters
                                    </a>

                                    <!-- Sort Order Toggle -->
                                    @if(request('sort_order') === 'asc')
                                        <a href="{{ request()->fullUrlWithQuery(['sort_order' => 'desc']) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-sort-amount-down-alt"></i> Descending
                                        </a>
                                    @else
                                        <a href="{{ request()->fullUrlWithQuery(['sort_order' => 'asc']) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-sort-amount-up"></i> Ascending
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    @if($favorites->count() > 0)
                        <div class="row g-3 g-md-4">
                            @foreach($favorites as $favorite)
                                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                    <div class="card h-100 shadow-sm anime-card">
                                        <div class="position-relative">
                                            <img src="{{ $favorite->image_url }}" class="card-img-top" alt="{{ $favorite->title }}" style="height: 250px; object-fit: cover;" loading="lazy">
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-{{ $favorite->status === 'Completed' ? 'success' : ($favorite->status === 'Watching' ? 'primary' : 'warning') }}">
                                                    {{ $favorite->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h6 class="card-title">{{ Str::limit($favorite->title, 30) }}</h6>
                                            <p class="card-text small">
                                                <i class="fas fa-star text-warning me-1"></i> {{ $favorite->score ?? 'N/A' }}
                                                @if($favorite->rating)
                                                    <br><i class="fas fa-heart text-danger me-1"></i> {{ $favorite->rating }}/10
                                                @endif
                                            </p>

                                            @if($favorite->review)
                                                <div class="mb-2">
                                                    <small class="text-muted fst-italic">
                                                        "{{ Str::limit($favorite->review, 100) }}"
                                                    </small>
                                                </div>
                                            @endif

                                            @if($favorite->tags->count() > 0)
                                                <div class="mb-2">
                                                    @foreach($favorite->tags as $tag)
                                                        <span class="badge bg-secondary text-xs">{{ $tag->name }}</span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="mt-auto pt-2">
                                                <div class="d-grid gap-1">
                                                    <a href="{{ route('anime.show', $favorite->anime_id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-eye me-1"></i> Details
                                                    </a>
                                                    <a href="{{ route('favorites.edit', $favorite->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>

                                                    <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this anime from favorites?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm w-100">
                                                            <i class="fas fa-trash me-1"></i> Remove
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            {{ $favorites->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-heart-broken fa-5x text-muted mb-4"></i>
                            <h3 class="text-muted">No favorites yet</h3>
                            <p class="text-muted">You haven't added any anime to your favorites yet.</p>
                            <a href="{{ route('anime.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-fire me-1"></i> Browse Top Anime
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .anime-card:hover {
        transform: translateY(-5px);
        transition: transform 0.3s ease;
    }
</style>
@endsection