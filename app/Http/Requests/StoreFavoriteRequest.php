<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFavoriteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Assuming authenticated users can add favorites
    }

    /**
     * Get the validation rules that apply to the request.
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
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'anime_id.unique' => 'This anime is already in your favorites.',
            'status.in' => 'The status must be Watching, Completed, or Plan to Watch.',
            'image_url.url' => 'The image URL must be a valid URL.'
        ];
    }
}
