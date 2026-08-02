<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Concerns\ValidatesSeatAvailability;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Counter sale: an admin books seats on behalf of a customer.
 *
 * Distinct from App\Http\Requests\StoreBookingRequest, which the API uses for
 * self-service bookings (that one takes the customer from the session).
 */
class StoreBookingRequest extends FormRequest
{
    use ValidatesSeatAvailability;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'showtime_id' => 'required|exists:showtimes,id',
            'seat_ids' => 'required|array|min:1',
            'seat_ids.*' => 'exists:seats,id',
            'booking_status' => 'required|in:pending,paid,cancelled',
            'payment_method' => 'nullable|in:cash,card,aba,acleda,wing',
        ];
    }

    public function messages(): array
    {
        return [
            'seat_ids.required' => 'Select at least one seat.',
        ];
    }
}
