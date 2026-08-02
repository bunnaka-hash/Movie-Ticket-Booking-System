<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
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
        // `sometimes` so the API can PATCH a subset of fields, while the admin
        // form (which posts every field) is still fully validated.
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'genre' => 'sometimes|required|string|max:100',
            'duration' => 'sometimes|required|integer|min:1',
            'language' => 'sometimes|required|string|max:100',
            'release_date' => 'sometimes|required|date',
            'poster' => 'nullable|string|max:255',
            'poster_file' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'trailer_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => 'sometimes|required|in:coming_soon,now_showing,ended',
        ];
    }
}
