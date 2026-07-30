<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MovieResource;
use App\Http\Resources\HallResource;

class ShowtimeResource extends JsonResource
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

            'movie' => new MovieResource($this->whenLoaded('movie')),

            'hall' => new HallResource($this->whenLoaded('hall')),

            'start_time' => $this->start_time,

            'end_time' => $this->end_time,

            'price' => $this->price,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
