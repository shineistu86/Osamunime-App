@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h1 class="mb-0"><i class="fas fa-tags text-warning me-2"></i>Daftar Genre</h1>
                    <p class="mb-0 opacity-75">Temukan anime berdasarkan genre kesukaanmu</p>
                </div>

                <div class="card-body">
                    <div class="row g-3">
                        @foreach($genres as $genre)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <a href="{{ route('anime.by.genre', $genre['id']) }}" class="btn btn-outline-primary w-100 genre-btn">
                                    {{ $genre['name'] }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .genre-btn {
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .genre-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        background-color: #0d6efd;
        color: white;
        text-decoration: none;
    }
</style>
@endsection