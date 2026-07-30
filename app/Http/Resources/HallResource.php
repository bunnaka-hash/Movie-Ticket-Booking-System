<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HallResource extends JsonResource
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
            'name' => $this->name,
            'total_seats' => $this->total_seats,

            'cinema' => $this->whenLoaded('cinema'),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
