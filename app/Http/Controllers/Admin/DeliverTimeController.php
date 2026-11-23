<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryTimesRequest;
use App\Models\Branch;
use App\Models\DeliveryTime;
use Illuminate\Http\Request;

class DeliverTimeController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 15);

        $deliveryTimes = DeliveryTime::query()
            ->when($request->filled('branch_id'), function ($query) use ($request) {
                $query->where('branch_id', $request->branch_id);
            })
            ->when($request->filled('day_of_week'), function ($query) use ($request) {
                $query->where('day_of_week', $request->day_of_week);
            })
            ->with(['branch'])
            ->latest('id')
            ->paginate($per_page);

        $branches = Branch::all();

        return view('deliver-times.index', [
            'deliveryTimes' => $deliveryTimes,
            'branches'      => $branches,
            'days'          => DeliveryTimesRequest::DAYS,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();

        return view('deliver-times.create', [
            'branches' => $branches,
            'days'     => DeliveryTimesRequest::DAYS,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeliveryTimesRequest $request)
    {
        $validated = $request->validated();

        DeliveryTime::create($validated);

        return redirect()->route('delivery-times.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryTime $deliveryTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DeliveryTime $deliveryTime)
    {
        $branches = Branch::all();

        return view('deliver-times.edit', [
            'deliveryTime' => $deliveryTime,
            'branches'     => $branches,
            'days'         => DeliveryTimesRequest::DAYS,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeliveryTimesRequest $request, DeliveryTime $deliveryTime)
    {
        $validated = $request->validated();
        $deliveryTime->update($validated);
        return redirect()->route('delivery-times.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeliveryTime $deliveryTime)
    {
        if ($deliveryTime->orders()->exists()) {
            return back()->with('error', __('delivery_times.cannot_delete_has_orders'));
        }

        $deliveryTime->delete();

        return back()->with('success', __('delivery_times.deleted'));
    }

    public function toggleStatus(DeliveryTime $deliveryTime)
    {
        $deliveryTime->update([
                'is_active' => !$deliveryTime->is_active ,
            ]);

            return response()->json([
                'success' => true,
                'is_active' => $deliveryTime->is_active,
            ]);
    }
}
