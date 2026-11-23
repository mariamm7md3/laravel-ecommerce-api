<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountCodeRequest;
use App\Models\DiscountCode;
use Illuminate\Http\Request;

class DiscountCodesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);

        $discountCodes = DiscountCode::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->search . '%');
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('is_active', $request->status);
            })
            ->withCount('orders')
            ->latest('id')
            ->paginate($per_page);

        return view('discount-codes.index', compact('discountCodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discount-codes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountCodeRequest $request)
    {
        $validated = $request->validated();

        DiscountCode::create($validated);

        return redirect()->route('discount-codes.index');
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
    public function edit(DiscountCode $discountCode)
    {
        return view('discount-codes.edit', compact('discountCode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountCodeRequest $request, DiscountCode $discountCode)
    {
        $discountCode->update($request->validated());
        return redirect()->route('discount-codes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DiscountCode $discountCode)
    {
        $discountCode->delete();
        return redirect()->route('discount-codes.index');
    }

    public function toggleStatus(DiscountCode $discountCode)
    {
        $discountCode->update([
            'is_active' => !$discountCode->is_active ,
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $discountCode->is_active,
        ]);
    }
}
