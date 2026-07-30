<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
{
    return [
        'id' => $this->id,
        'row_name' => $this->row_name,
        'seat_number' => $this->seat_number,

        'label' => $this->row_name . $this->seat_number,

        'seat_type' => $this->seat_type,

        'hall' => $this->whenLoaded('hall'),

        'created_at' => $this->created_at,
        'updated_at' => $this->updated_at,
    ];
}
}
