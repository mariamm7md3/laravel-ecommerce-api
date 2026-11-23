<?php

namespace App\Http\Controllers;

use App\Http\Resources\CartItemResource;
use App\Http\Resources\PopularProductResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)

    {
        $request->user()->load('wishlist.items');

        $cart = $request->user()->cart()->with([
            'items.variant.product',
            'items.variant.productunit',
            'items.variant.sales' => fn($q) =>
            $q->active()->where('end_date', '>=', now()),
        ])->first();

        if(!$cart)
        {
            return $this->successResponse(__('messages.cart.empty'), []);
        }

        $items = CartItemResource::collection($cart->items);

        $total = $cart->items->sum(function ($item) {
            $variant    = $item->variant;
            $activeSale = $variant->sales->first();
            $price      = $variant->price;
            $finalPrice = $activeSale
                ? round($price - ($price * ($activeSale->percentage / 100)), 2)
                : $price;
            return round($finalPrice * $item->quantity, 2);
        });

        return $this->successResponse(
            __('messages.cart.fetched'),
            [
                'items'=>$items,
                'total'=>$total,
            ]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id',
            'quantity'           => 'required|integer|min:1',
            'preparation_note'   => 'nullable|string',
        ]);

        $cart = $request->user()->cart ?? Cart::create([
            'user_id' => $request->user()->id,
        ]);


        $variant = ProductVariant::find($request->product_variant_id);

        $exists = $cart->items()->where('product_variant_id', $request->product_variant_id)->exists();
        if ($exists) {
            return $this->errorResponse(__('messages.cart.already_exists'), 409);
        }

        if ($request->quantity > $variant->stock_quantity) {
            return $this->errorResponse(__('messages.cart.out_of_stock', ['count' => $variant->stock_quantity]), 422);
        }

        if ($request->quantity > $variant->product_limit) {
            return $this->errorResponse(
                __('messages.cart.limit_exceeded', ['limit' => $variant->product_limit]),
                422
            );
        }

        $cart->items()->create([
            'product_variant_id' => $request->product_variant_id,
            'quantity' => $request->quantity,
            'preparation_note' => $request->preparation_note,
        ]);
        return $this->successResponse(__('messages.cart.item_added'), null , 201);

    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $variant = $item->variant;

        if ($request->quantity > $variant->stock_quantity) {
            return $this->errorResponse( __('messages.cart.out_of_stock', ['count' => $variant->stock_quantity]), 422);
        }

        if ($request->quantity > $variant->product_limit) {
            return $this->errorResponse(
                __('messages.cart.limit_exceeded', ['limit' => $variant->product_limit]),
                422
            );
        }

        $item->update(['quantity'=> $request->quantity]);

        return $this->successResponse(__('messages.cart.item_updated'),null , 201);
    }

    public function destroy(Request $request , CartItem $item)
    {
        $item->delete();

        $cart = $request->user()->cart;
        if ($cart && $cart->items()->count() === 0) {
            $cart->delete();
        }
        return $this->successResponse(__('messages.cart.item_removed'));
    }
}
