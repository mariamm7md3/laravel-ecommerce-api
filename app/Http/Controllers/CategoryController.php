<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\PopularProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Traits\ApiResponseTrait;

class CategoryController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $categories = Category::active()
            ->withCount('products')
            ->paginate(10);

        return $this->paginatedResponse(
            __('messages.category.index'),
            CategoryResource::collection($categories)
        );
    }

    public function show(Category $category)
    {
        $products =Product::active()
            ->popular()
            ->whereHas('categories',fn($q) =>
            $q->where('categories.id' , $category->id)
            )
            ->paginate(10);

        return $this->paginatedResponse(
            __('messages.category.show'),
            PopularProductResource::collection($products)
        );
    }
}
