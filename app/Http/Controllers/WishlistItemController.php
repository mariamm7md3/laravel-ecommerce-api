<?php

namespace App\Http\Controllers;

use App\Http\Resources\PopularProductResource;
use App\Models\WishListItem;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class WishlistItemController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $wishlist = $request->user()->wishList()->with(['items.product'])->first();

        if(!$wishlist){
            return $this->successResponse(
                __('messages.wishlist.empty'),
                []
            );
        }

        return $this->successResponse(
            __('messages.wishlist.fetched'),
            // wishlist resource
            PopularProductResource::collection(
                $wishlist->items->map(fn($item) => $item->product)
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

//        create wishlist
        $wishlist = $request->user()->wishList()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);

//        check if item already exist
        $exists = $wishlist->items()->where('product_id', $request->product_id)->exists();

        if($exists){
            return $this->errorResponse(
                __('messages.wishlist.already_exists'),
                409
            );
        }

        $wishlist->items()->create(['product_id' => $request->product_id]);

        return $this->successResponse(__('messages.wishlist.item_added'), null , 201);
    }

    public function destroy(Request $request , WishlistItem $item)
    {
        $item->delete();

        $wishlist = $request->user()->wishlist;
        if ($wishlist && $wishlist->items()->count() === 0) {
            $wishlist->delete();
        }

        return $this->successResponse(__('messages.wishlist.item_removed'));
    }
}
