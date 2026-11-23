<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PopularProductResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Traits\ApiResponseTrait;
use App\Traits\ImageTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    use ApiResponseTrait;
    use ImageTrait;
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //user
        $user = $request->user('sanctum');
        $name = $user ? $user->first_name : null;
        $photo = $user ? $this->getImageUrl($user->photo) : null;

        //Main address
        $mainAddress = null;
        if($user)
        {
            $mainAddress = $user->addresses()->where('is_main',true)->first();
        }

        $wishlistProductIds = $user->wishList
            ?->items()
            ->pluck('product_id')
            ->toArray() ?? [];

        //category
        $categories = Category::active()->limit(5)->get();

        //popular products
        $popularProducts = Product::active()
            ->popular()
            ->limit(5)
            ->get()
            ->each(function ($product) use ($wishlistProductIds) {
                $product->is_favourite = in_array($product->id, $wishlistProductIds);
            });


        return $this->successResponse(__('messages.home.data'), [
            'name'=>$name,
            'photo'=>$photo,
            'selected_address'=>$mainAddress? new AddressResource($mainAddress) : null,
            'categories'       => CategoryResource::collection($categories),
            'popular_products' => PopularProductResource::collection($popularProducts),
        ]);
    }
}
