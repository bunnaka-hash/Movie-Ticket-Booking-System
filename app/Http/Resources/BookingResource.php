<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ShowtimeResource;
use App\Http\Resources\BookingDetailResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ],

            'booking_code' => $this->booking_code,

            'booking_status' => $this->booking_status,

            'payment_method' => $this->payment_method,

            'booked_at' => $this->booked_at,

            'total_price' => $this->total_price,

            'showtime' => new ShowtimeResource(
                $this->whenLoaded('showtime')
            ),

            'booking_details' => BookingDetailResource::collection(
                $this->whenLoaded('bookingDetails')
            ),

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}