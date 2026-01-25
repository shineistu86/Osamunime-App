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

                    @if($favorites->count() > 0)
                        <div class="row g-4">
                            @foreach($favorites as $favorite)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="card h-100 shadow-sm anime-card">
                                        <div class="position-relative">
                                            <img src="{{ $favorite->image_url }}" class="card-img-top" alt="{{ $favorite->title }}" style="height: 300px; object-fit: cover;">
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-{{ $favorite->status === 'Completed' ? 'success' : ($favorite->status === 'Watching' ? 'primary' : 'warning') }}">
                                                    {{ $favorite->status }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ Str::limit($favorite->title, 30) }}</h5>
                                            <p class="card-text">
                                                <i class="fas fa-star text-warning me-1"></i> {{ $favorite->score ?? 'N/A' }}
                                            </p>

                                            <div class="mt-auto pt-2">
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('anime.show', $favorite->anime_id) }}" class="btn btn-primary">
                                                        <i class="fas fa-eye me-1"></i> View Details
                                                    </a>
                                                    <a href="{{ route('favorites.edit', $favorite->id) }}" class="btn btn-info">
                                                        <i class="fas fa-edit me-1"></i> Edit
                                                    </a>

                                                    <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this anime from favorites?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger w-100">
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