@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow">
                <div class="card-header bg-warning text-dark text-center py-3">
                    <h1 class="mb-0"><i class="fas fa-edit me-2"></i>{{ __('Edit Favorite') }}</h1>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ $favorite->image_url }}" class="img-fluid rounded shadow" alt="{{ $favorite->title }}" loading="lazy">
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $favorite->title }}</h3>

                            <form method="POST" action="{{ route('favorites.update', $favorite->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="score" class="form-label">Score</label>
                                    <input type="number" class="form-control" id="score" name="score" step="0.1" min="0" max="10" value="{{ old('score', $favorite->score) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <select name="rating" id="rating" class="form-select">
                                        <option value="">Select Rating</option>
                                        @for($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}" {{ $favorite->rating == $i ? 'selected' : '' }}>
                                                {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="review" class="form-label">Review</label>
                                    <textarea name="review" id="review" class="form-control" rows="3">{{ old('review', $favorite->review) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="Plan to Watch" {{ $favorite->status === 'Plan to Watch' ? 'selected' : '' }}>Plan to Watch</option>
                                        <option value="Watching" {{ $favorite->status === 'Watching' ? 'selected' : '' }}>Watching</option>
                                        <option value="Completed" {{ $favorite->status === 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="4">{{ old('notes', $favorite->notes) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="tags" class="form-label">Tags</label>
                                    <input type="text" name="tags" id="tags" class="form-control" value="{{ old('tags', $favorite->tags->pluck('name')->join(', ')) }}" placeholder="Enter tags separated by commas">
                                    <small class="form-text text-muted">Separate tags with commas (e.g., action, comedy, drama)</small>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('favorites.index') }}" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-arrow-left me-1"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i> Update Favorite
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection