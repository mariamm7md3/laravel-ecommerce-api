<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Industry;
use App\Models\Product;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $products = Product::query()
            ->forAdminList()
            ->adminFilter($request)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $categories = Category::all();
        $industries = Industry::all();

        return view('products.index', compact('products' , 'categories', 'industries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $industries = Industry::all();
        return view('products.create', compact('categories', 'industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $photoPath = $this->uploadImage($request->file('photo'), 'products');

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'industry_id' => $validated['industry_id'],
            'photo' => $photoPath,
            'price' => $validated['price'],
        ]);

        $product->categories()->sync($validated['categories']);
        $product->load('categories');
        $product->searchable();

        return redirect()->route('products.show', $product);
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        $product->load([
            'variants',
            'variants.productSize',
            'variants.productUnit',
            'categories',
            'industry',
            'variants.sales',
        ]);


        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product->load(['categories', 'industry']);

        $industries = Industry::all();
        $categories = Category::all();

        return view('products.edit' , compact('product', 'categories', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $photoPath = $product->photo;

        if ($request->hasFile('photo')) {
            $photoPath = $this->updateImage($request->file('photo'), $product->photo, 'products');
        }

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'industry_id' => $validated['industry_id'],
            'price' => $validated['price'],
            'photo' => $photoPath,
        ]);

        $product->categories()->sync($validated['categories']);
        $product->load('categories');
        $product->searchable();

        return redirect()->route('products.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
//        $this->deleteImage($product->photo);
        $product->delete();
        return redirect()->route('products.index');
    }

    public function toggleStatus(Product $product)
    {
        $product->update([
            'is_active' => !$product->is_active ,
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $product->is_active,
        ]);
    }
}
