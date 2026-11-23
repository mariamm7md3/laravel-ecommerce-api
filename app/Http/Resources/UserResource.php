<?php

namespace App\Http\Resources;

use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    use ImageTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->first_name . ' ' . $this->last_name,
            'email'         => $this->email,
            'phone'         => $this->phone,
            'photo'         => $this->getImageUrl($this->photo),
            'gender'        => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'is_active'     => $this->is_active,
        ];
    }
}
