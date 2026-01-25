@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h1 class="mb-0">{{ $anime['title'] }}</h1>
                    <p class="mb-0 opacity-75">{{ $anime['title_japanese'] ?? '' }}</p>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <img src="{{ $anime['images']['jpg']['large_image_url'] ?? $anime['images']['jpg']['image_url'] }}" class="img-fluid rounded shadow" alt="{{ $anime['title'] }}">

                            <div class="mt-3">
                                @if($anime['score'])
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-star text-warning me-2"></i>
                                        <h4 class="mb-0">{{ $anime['score'] }}</h4>
                                        <span class="text-muted ms-2">({{ number_format($anime['scored_by'] ?? 0) }} users)</span>
                                    </div>
                                @endif

                                <div class="mt-3">
                                    <h5>Information</h5>
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-video me-2 text-primary"></i> <strong>Type:</strong> {{ $anime['type'] ?? 'N/A' }}</li>
                                        <li><i class="fas fa-film me-2 text-primary"></i> <strong>Episodes:</strong> {{ $anime['episodes'] ?? 'N/A' }}</li>
                                        <li><i class="fas fa-flag me-2 text-primary"></i> <strong>Status:</strong> {{ $anime['status'] ?? 'N/A' }}</li>
                                        <li><i class="fas fa-calendar me-2 text-primary"></i> <strong>Aired:</strong> {{ $anime['aired']['string'] ?? 'N/A' }}</li>
                                        <li><i class="fas fa-sun me-2 text-primary"></i> <strong>Season:</strong> {{ ucfirst($anime['season'] ?? 'Unknown') }} {{ $anime['year'] ?? 'Unknown' }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3>Synopsis</h3>
                                <p class="lead">{!! nl2br(e($anime['synopsis'] ?? 'No synopsis available.')) !!}</p>
                            </div>

                            @if($anime['studios'] && count($anime['studios']) > 0)
                                <div class="mb-4">
                                    <h4><i class="fas fa-building me-2 text-primary"></i> Studios</h4>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($anime['studios'] as $studio)
                                            <span class="badge bg-secondary fs-6">{{ $studio['name'] }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($anime['genres'] && count($anime['genres']) > 0)
                                <div class="mb-4">
                                    <h4><i class="fas fa-tags me-2 text-primary"></i> Genres</h4>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($anime['genres'] as $genre)
                                            <span class="badge bg-info fs-6">{{ $genre['name'] }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @auth
                                <div class="card border-primary mt-4">
                                    <div class="card-header bg-primary text-white">
                                        <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Add to Favorites</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('favorites.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                                            <input type="hidden" name="title" value="{{ $anime['title'] }}">
                                            <input type="hidden" name="image_url" value="{{ $anime['images']['jpg']['image_url'] }}">
                                            <input type="hidden" name="score" value="{{ $anime['score'] }}">

                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select name="status" id="status" class="form-select">
                                                    <option value="Plan to Watch" selected>Plan to Watch</option>
                                                    <option value="Watching">Watching</option>
                                                    <option value="Completed">Completed</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="notes" class="form-label">Notes</label>
                                                <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Add your notes here..."></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-heart me-1"></i> Add to Favorites
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <div class="card border-warning mt-4">
                                    <div class="card-body text-center">
                                        <i class="fas fa-lock fa-2x text-warning mb-3"></i>
                                        <h5 class="card-title">Log in to add to favorites</h5>
                                        <p class="card-text">Sign in to track this anime in your personal collection.</p>
                                        <a href="{{ route('login') }}" class="btn btn-warning">
                                            <i class="fas fa-sign-in-alt me-1"></i> Login
                                        </a>
                                    </div>
                                </div>
                            @endauth

                            <div class="mt-4">
                                <a href="{{ route('anime.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to Anime List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection