<?php

namespace App\Http\Resources;

use App\Traits\ImageTrait;
use App\Traits\Translatable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
//        return parent::toArray($request);
        return [
            'id'          => $this->id,
            'name'        => $this->translate($this->name),
            'photo'         => $this->getImageUrl($this->photo),
            'description' => $this->translate($this->description),
            'rate'        => $this->rate,
            'industry'    => $this->translate($this->industry?->name),
            'categories' => $this->categories->map(function ($category) {
                return $this->translate($category->name);
            }),
            // loop at variant
            'variants'    => $this->variants->map(function ($variant) {
                $activeSale = $variant->sales->first();
                return [
                    'id'            => $variant->id,
                    'unit'          => $this->translate($variant->productunit->name ?? null),
                    'unit'          => $this->translate($variant->productUnit->name ?? null),
                    'price'         => $variant->price,
                    'stock'         => $variant->stock_quantity,
                    'has_discount'  => (bool) $activeSale,
                    'final_price'   => $activeSale
                        ? round($variant->price - ($variant->price * ($activeSale->percentage / 100)), 2)
                        : $variant->price,
                    'discount_percentage' => $activeSale?->percentage ?? 0,
                    'sale_ends_at'  => $activeSale?->end_date ?? null,
                ];
            }),
        ];
    }
}
