<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryRequest;
use App\Models\Industry;
use Illuminate\Http\Request;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);

        $industries = Industry::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name->ar', 'like', '%' . $request->search . '%')
                    ->orWhere('name->en', 'like', '%' . $request->search . '%');
            })
            ->WithCount('products')
            ->latest('id')
            ->paginate($per_page);

        return view ('industries.index' , compact('industries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('industries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IndustryRequest $request)
    {
        $validated = $request->validated();

        Industry::create($validated);

        return redirect()->route('industries.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Industry $industry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Industry $industry)
    {
        return view ('industries.edit', compact('industry'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IndustryRequest $request, Industry $industry)
    {
        $validated = $request->validated();
        $industry->update($validated);
        return redirect()->route('industries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Industry $industry)
    {
        $industry->delete();
        return redirect()->route('industries.index');
    }
}
