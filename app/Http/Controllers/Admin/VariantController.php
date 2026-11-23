<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VariantRequest;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductUnit;
use App\Models\ProductVariant;
use App\Models\Sale;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Product $product)
    {
        $productSize = ProductSize::all();
        $productUnit = ProductUnit::all();
        $activeSales = Sale::active()->get();

        return view('variants.create', compact('productSize' , 'productUnit' , 'product' , 'activeSales'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VariantRequest $request, Product $product)
    {
        $validated = $request->validated();
        $saleIds = $validated['sale_ids'] ?? [];
        unset($validated['sale_ids']);

        $variant = $product->variants()->create($validated);
        $variant->sales()->sync($saleIds);

        return redirect()
            ->route('products.show', $product)
            ->with('success', __('variants.variant_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductVariant $variant)
    {
        $product = $variant->product;

        $productSize = ProductSize::all();
        $productUnit = ProductUnit::all();
        $activeSales = Sale::active()->get();

        return view('variants.edit', compact('variant', 'productSize', 'productUnit', 'product', 'activeSales'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VariantRequest $request, ProductVariant $variant)
    {
        $validated = $request->validated();
        $saleIds = $validated['sale_ids'] ?? [];
        unset($validated['sale_ids']);

        $variant->update($validated);
        $variant->sales()->sync($saleIds);

        return redirect()->route('products.show', $variant->product)
            ->with('success', __('variants.variant_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->route('products.show', $variant->product)
            ->with('success', 'Variant deleted successfully.');
    }
}
