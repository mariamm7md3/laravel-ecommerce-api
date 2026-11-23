<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class   AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'nickname'     => $this->nickname,
            'phone'        => $this->phone,
            'type'         => $this->type,
            'governate'    => $this->governate,
            'neighborhood' => $this->neighborhood,
            'building'     => $this->building,
            'floor'        => $this->floor,
            'apartment'    => $this->apartment,
            'details'      => $this->details,
            'is_main'      => $this->is_main,
            'is_active'    => $this->is_active,
        ];
    }
}
