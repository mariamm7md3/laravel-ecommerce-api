<?php

namespace App\Http\Controllers;

use App\Models\ProductUnit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $units = ProductUnit::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate($request->query('per_page' , 10));

        return view('units.index' , compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create');
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

        ProductUnit::create($validated);

        return redirect()
            ->route('units.index')
            ->with('unit created successfully.');
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
    public function edit(ProductUnit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, productUnit $unit)
    {
        $validated = $request->validate([
            'name.en' => 'required|string|max:255',
            'name.ar' => 'required|string|max:255',
        ]);

        $unit->update($validated);

        return redirect()
            ->route('units.index')
            ->with('unit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductUnit $unit)
    {
        $unit->delete();

        return redirect()
            ->route('units.index')
            -> with('success', 'Unit deleted successfully!');
    }

    public function toggleStatus(ProductUnit $unit)
    {
        $unit->update([
            'is_active' => !$unit->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $unit->is_active,
        ]);
    }
}
