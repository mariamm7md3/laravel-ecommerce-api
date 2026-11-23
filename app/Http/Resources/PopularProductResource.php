<?php

namespace App\Http\Resources;

use App\Traits\ImageTrait;
use App\Traits\Translatable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PopularProductResource extends JsonResource
{
    use Translatable;
    use ImageTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $cheapestVariant    = $this->variants->first();
        $originalPrice      = $cheapestVariant?->price ?? 0;
        $finalPrice         = $originalPrice;
        $hasDiscount        = false;
        $discountPercentage = 0;

        $activeSale = $cheapestVariant?->sales->first();
        if ($activeSale) {
            $hasDiscount        = true;
            $discountPercentage = $activeSale->percentage;
            $finalPrice         = $originalPrice - ($originalPrice * ($discountPercentage / 100));
        }

        return [
            'id'                  => $this->id,
            'name'                => $this->translate($this->name),
            'photo'               => $this->getImageUrl($this->photo),
            'is_favorite'         => $this->is_favourite ?? false,
            'original_price'      => $originalPrice,
            'final_price'         => round($finalPrice, 2),
            'has_discount'        => $hasDiscount,
            'discount_percentage' => $discountPercentage,
            'total_sold' => (int) ($this->total_sold ?? 0),
        ];
    }
}
