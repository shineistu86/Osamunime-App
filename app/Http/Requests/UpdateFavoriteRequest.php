<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFavoriteRequest extends FormRequest
{
    /**
     * Cek apakah user punya izin buat bikin request ini.
     */
    public function authorize(): bool
    {
        return true; // Anggap aja user yang udah login bisa update favorit mereka
    }

    /**
     * Ambil aturan validasi yang berlaku buat request ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
            'status.in' => 'Status harus salah satu dari: Watching, Completed, atau Plan to Watch.'
        ];
    }
}
