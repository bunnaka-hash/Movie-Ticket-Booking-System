<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'genre' => 'required|string|max:100',
            'duration' => 'required|integer|min:1',
            'language' => 'required|string|max:100',
            'release_date' => 'required|date',
            'poster' => 'nullable|string|max:255',
            // Admin form upload; the API keeps posting `poster` as a string.
            'poster_file' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'trailer_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => 'required|in:coming_soon,now_showing,ended',
        ];
    }
}
