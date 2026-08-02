<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Editing an existing booking covers its status, payment and check-in only.
 * Seats are fixed once sold - cancel and rebook to change them.
 */
class UpdateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'booking_status' => 'required|in:pending,paid,cancelled',
            'payment_method' => 'nullable|in:cash,card,aba,acleda,wing',
            'checked_in' => 'nullable|boolean',
        ];
    }
}
