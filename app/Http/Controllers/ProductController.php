<?php

namespace App\Http\Controllers;

use App\Http\Resources\PopularProductResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {
        $query= Product::active()
                ->popular()
            ->filter($request);


        $products = $query->paginate(10);

        return $this->paginatedResponse(
            __('messages.product.index'),
            PopularProductResource::collection($products),
        );
    }

    public function show(Product $product)
    {
        $product->load([
            'industry',
            'categories',
            'variants.productunit',
            'variants.productUnit',
            'variants.sales' => fn($q) =>
            $q->active()->where('end_date', '>=', now()),
        ]);

        return $this->successResponse(
            __('messages.product.show'),
            new ProductResource($product),
        );
    }


}
