<?php

namespace App\Http\Resources;

use App\Traits\ImageTrait;
use App\Traits\Translatable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    use Translatable;
    use ImageTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->translate($this->name),
            'description'=>$this->translate($this->description),
            'icon'         => $this->getImageUrl($this->icon),
            'products_count' => $this->products_count,
        ];
    }
}
