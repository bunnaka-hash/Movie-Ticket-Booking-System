<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'showtime_id' => 'required|exists:showtimes,id',

            'seat_ids' => 'required|array|min:1',

            'seat_ids.*' => 'exists:seats,id',

            'payment_method' => 'nullable|in:cash,card,aba,acleda,wing',
        ];
    }
}
