<?php

namespace App\Http\Resources;

use App\Traits\ImageTrait;
use App\Traits\Translatable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OrderResource extends JsonResource
{
    use Translatable , ImageTrait ;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'status'          => $this->status,
            'date'            => $this->date,

            'branch'          => [
                'id'   => $this->branch->id,
                'name' => $this->translate($this->branch->name),
            ],

            'address' => [
                'id'           => $this->address->id,
                'nickname'     => $this->address->nickname,
                'phone'        => $this->address->phone,
                'governate'    => $this->address->governate,
                'neighborhood' => $this->address->neighborhood,
                'building'     => $this->address->building,
                'floor'        => $this->address->floor,
                'apartment'    => $this->address->apartment,
                'details'      => $this->address->details,
            ],

            'delivery_time'   => [
                'id'          => $this->deliveryTime->id,
                'day_of_week' => ucfirst($this->deliveryTime->day_of_week),
                'start_time'  => Carbon::parse($this->deliveryTime->start_time)->format('h:i A'),
                'end_time'    => Carbon::parse($this->deliveryTime->end_time)->format('h:i A'),
            ],

            'items'           => $this->items->map(function ($item) {
                $variant = $item->variant;

                return [
                    'id'       => $item->id,
                    'name'     => $this->translate($variant->product->name),
                    'photo'    => $this->getImageUrl($variant->product->photo),
                    'size'     => $this->translate($variant->productSize->name ?? null),
                    'unit'     => $this->translate($variant->productUnit->name ?? null),
                    'quantity' => $item->quantity,
                    'price'    => $item->price,
                    'subtotal' => round($item->price * $item->quantity, 2),
                ];
            }),

            'payment' => [
                'method'      => $this->payment->paymentMethod->name,
                'status'      => $this->payment->status,
                'payment_url' => $this->payment->payment_url,
            ],

            'sub_total'       => $this->sub_total,
            'shipping'        => $this->shipping,
            'discount'        => $this->discount,
            'total'           => $this->total,

            'discount_code'   => $this->discountCodes->first()?->code,

            'additional_info' => $this->additional_info,

            'created_at'      => $this->created_at->format('Y-m-d H:i'),
        ];
    }
}
