<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavoriteRequest extends FormRequest
{
    /**
     * Cek apakah user punya izin buat bikin request ini.
     */
    public function authorize(): bool
    {
        return true; // Anggap aja user yang udah login bisa nambahin favorit
    }

    /**
     * Ambil aturan validasi yang berlaku buat request ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'anime_id' => 'required|integer|unique:favorites,anime_id,NULL,id,user_id,' . auth()->id(),
            'title' => 'required|string|max:255',
            'image_url' => 'required|url',
            'score' => 'nullable|numeric|min:0|max:10',
            'rating' => 'nullable|integer|min:1|max:10',
            'review' => 'nullable|string|max:1000',
            'status' => 'required|in:Watching,Completed,Plan to Watch',
            'notes' => 'nullable|string|max:1000',
            'tags' => 'nullable|string|max:255'
        ];
    }

    /**
     * Ambil pesan error buat aturan validasi yang udah didefinisikan.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'anime_id.unique' => 'Anime ini udah ada di favorit kamu.',
            'status.in' => 'Status harus salah satu dari: Watching, Completed, atau Plan to Watch.',
            'image_url.url' => 'URL gambar harus berupa URL yang valid.'
        ];
    }
}
