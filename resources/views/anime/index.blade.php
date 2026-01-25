@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h1 class="mb-0"><i class="fas fa-fire text-warning me-2"></i>{{ __('Top Anime') }}</h1>
                    <p class="mb-0 opacity-75">Discover the most popular anime series</p>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row g-3 g-md-4">
                        @forelse($animes as $anime)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                <div class="card h-100 shadow-sm anime-card">
                                    <div class="position-relative">
                                        <img src="{{ $anime['images']['jpg']['image_url'] ?? 'https://via.placeholder.com/225x300' }}" class="card-img-top" alt="{{ $anime['title'] }}" style="height: 250px; object-fit: cover;" loading="lazy">
                                        @if($anime['score'])
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-star me-1"></i>{{ $anime['score'] }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title">{{ Str::limit($anime['title'], 30) }}</h6>
                                        <p class="card-text small">
                                            <i class="fas fa-video me-1"></i> {{ $anime['episodes'] ?? 'N/A' }} |
                                            <i class="fas fa-flag me-1"></i> {{ $anime['status'] ?? 'N/A' }}
                                        </p>

                                        <div class="mt-auto pt-2">
                                            <a href="{{ route('anime.show', $anime['mal_id']) }}" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-eye me-1"></i> Details
                                            </a>

                                            @auth
                                                <form class="mt-2" action="{{ route('favorites.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                                                    <input type="hidden" name="title" value="{{ $anime['title'] }}">
                                                    <input type="hidden" name="image_url" value="{{ $anime['images']['jpg']['image_url'] }}">
                                                    <input type="hidden" name="score" value="{{ $anime['score'] }}">
                                                    <input type="hidden" name="status" value="Plan to Watch">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                        <i class="fas fa-heart me-1"></i> Favorite
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                                                    <i class="fas fa-heart me-1"></i> Login
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                    <h4 class="text-muted">No anime found</h4>
                                    <p class="text-muted">Try adjusting your search criteria</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if(!empty($animes))
                        <div class="d-flex justify-content-center mt-4">
                            {{-- Pagination would go here --}}
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