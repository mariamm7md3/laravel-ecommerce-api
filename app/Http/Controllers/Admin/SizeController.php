<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sizes = ProductSize::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate($request->query('per_page' , 10));

        return view('sizes.index' , compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
        ]);

        ProductSize::create($validated);

        return redirect()
            ->route('sizes.index')
            ->with('success', 'Size created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductSize $size)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(productSize $size)
    {
        return view('sizes.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, productSize $size)
    {
        $validated = $request->validate([
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
            ]);
        $size->update($validated);

        return redirect()
            ->route('sizes.index')
            ->with('success', 'Size updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductSize $size)
    {
        $size->delete();

        return back()->with('success', 'Size deleted successfully.');
    }

    public function toggleStatus(ProductSize $size)
    {
        $size->update(['is_active' => !$size->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $size->is_active,
        ]);
    }
}
