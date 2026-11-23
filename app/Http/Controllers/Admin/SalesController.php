<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use Pdo\Sqlite;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales = Sale::query()
            ->withCount('variants')
            ->when($request->status === 'active', fn($q) => $q->active())
            ->when($request->status === 'upcoming', fn($q) => $q->upcoming())
            ->when($request->status === 'expired', fn($q) => $q->expired())
            ->latest('id')
            ->paginate($request->query('per_page' , 10));

        return view('sales.index' , compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'percentage' => ['required', 'numeric', 'min:1', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
            'is_active'  => ['nullable', 'boolean'],

        ], [

            'percentage.required' => __('sales.validation_percentage_required'),
            'percentage.numeric'  => __('sales.validation_percentage_numeric'),
            'percentage.min'      => __('sales.validation_percentage_min'),
            'percentage.max'      => __('sales.validation_percentage_max'),
            'start_date.required' => __('sales.validation_start_date_required'),
            'start_date.date'     => __('sales.validation_start_date_date'),
            'end_date.required'   => __('sales.validation_end_date_required'),
            'end_date.date'       => __('sales.validation_end_date_date'),
            'end_date.after_or_equal' => __('sales.validation_end_date_after'),

        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Sale::create($validated);

        return redirect()

            ->route('sales.index')

            ->with('success', __('sales.sale_created_successfully'));
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
    public function edit(Sale $sale)
    {
        return view('sales.edit' , compact('sale'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'percentage' => ['required', 'numeric', 'min:1', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
        ], [
            'percentage.required' => __('sales.validation_percentage_required'),
            'percentage.numeric'  => __('sales.validation_percentage_numeric'),
            'percentage.min'      => __('sales.validation_percentage_min'),
            'percentage.max'      => __('sales.validation_percentage_max'),
            'start_date.required' => __('sales.validation_start_date_required'),
            'start_date.date'     => __('sales.validation_start_date_date'),
            'end_date.required'   => __('sales.validation_end_date_required'),
            'end_date.date'       => __('sales.validation_end_date_date'),
            'end_date.after_or_equal' => __('sales.validation_end_date_after'),
        ]);

        $sale->update($validated);

        return redirect()
            ->route('sales.index')
            ->with('success', __('sales.sale_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index');
    }

    public function toggleStatus(Sale $sale)
    {
        $sale->update(['is_active' => !$sale->is_active]);

        return response()->json([
            'success'    => true,
            'is_active'  => $sale->is_active,
            'status'     => $sale->status,
            'badge_html' => view('sales.partials.status-badge', ['sale' => $sale])->render(),
        ]);
    }
}
