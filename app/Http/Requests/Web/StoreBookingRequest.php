<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\Concerns\ValidatesSeatAvailability;
use Illuminate\Foundation\Http\FormRequest;

/**
 * A signed-in customer booking their own seats from the website.
 * The customer is taken from the session, never from the form.
 */
class StoreBookingRequest extends FormRequest
{
    use ValidatesSeatAvailability;

    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'showtime_id' => 'required|exists:showtimes,id',
            'seat_ids' => 'required|array|min:1|max:10',
            'seat_ids.*' => 'exists:seats,id',
            'payment_method' => 'nullable|in:cash,card,aba,acleda,wing',
        ];
    }

    public function messages(): array
    {
        return [
            'seat_ids.required' => 'Please select at least one seat.',
            'seat_ids.max' => 'You can book at most 10 seats in one order.',
        ];
    }
}
