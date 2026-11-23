<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $variant    = $this->variant;
        $activeSale = $variant->sales->first();
        $price      = $variant->price;
        $finalPrice = $activeSale
            ? round($price - ($price * ($activeSale->percentage / 100)), 2)
            : $price;

        $inWishlist = $request->user()->wishlist
            ?->items->contains('product_id', $variant->product_id)
            ?? false;

        return [
            'cart_item_id'        => $this->id,
            'product_name'        => $variant->product->name,
//            'photo'               => $variant->product->photo
//                ? asset('storage/' . $variant->product->photo)
//                : null,
            'size'                => $variant->productSize->name ?? null,
            'unit'                => $variant->productUnit->name ?? null,
            'quantity'            => $this->quantity,
            'original_price'      => $price,
            'final_price'         => $finalPrice,
            'total_price'         => round($finalPrice * $this->quantity, 2),
            'has_discount'        => (bool) $activeSale,
            'discount_percentage' => $activeSale?->percentage ?? 0,
            'preparation_note'    => $this->preparation_note,
            'in_wishlist'         => $inWishlist,
        ];
    }
}
