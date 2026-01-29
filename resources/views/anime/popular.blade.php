@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h1 class="mb-0"><i class="fas fa-fire text-warning me-2"></i>{{ __('Anime Populer') }}</h1>
                    <p class="mb-0 opacity-75">{{ __('Daftar anime paling populer saat ini') }}</p>
                </div>

                <div class="card-body">
                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row g-3 g-md-4">
                        @forelse($animes as $anime)
                            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                <div class="card h-100 shadow-sm anime-card">
                                    <div class="position-relative">
                                        <img src="{{ $anime['images']['jpg']['image_url'] ?? 'https://placehold.co/300x400?text=No+Image' }}" class="card-img-top" alt="{{ $anime['title'] }}" style="height: 250px; object-fit: cover;" loading="lazy">
                                        @if(isset($anime['score']) && $anime['score'])
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
                                            <i class="fas fa-video me-1"></i> {{ $anime['episodes'] ?? __('N/A') }} |
                                            <i class="fas fa-flag me-1"></i> {{ $anime['status'] ?? __('N/A') }}
                                        </p>

                                        <div class="mt-auto pt-2">
                                            <a href="{{ route('anime.show', $anime['mal_id']) }}" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-eye me-1"></i> {{ __('Details') }}
                                            </a>

                                            @auth
                                                <form action="{{ route('favorites.store') }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <input type="hidden" name="anime_id" value="{{ $anime['mal_id'] }}">
                                                    <input type="hidden" name="title" value="{{ $anime['title'] }}">
                                                    <input type="hidden" name="image_url" value="{{ $anime['images']['jpg']['image_url'] }}">
                                                    <input type="hidden" name="score" value="{{ $anime['score'] ?? null }}">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                        <i class="fas fa-heart me-1"></i> {{ __('Favorite') }}
                                                    </button>
                                                </form>
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                                                    <i class="fas fa-heart me-1"></i> {{ __('Favorite') }}
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                                    <h4>{{ __('Tidak Ada Anime Ditemukan') }}</h4>
                                    <p class="text-muted">{{ __('Anime yang Anda cari tidak ditemukan.') }}</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        @include('partials.pagination')
                    </div>
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