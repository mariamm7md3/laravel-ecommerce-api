<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->input ('per_page' , 10) ;

        $branches = Branch::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('name->ar', 'like', '%' . $request->search . '%')
                    ->orWhere('name->en', 'like', '%' . $request->search . '%');
            })
            ->withCount('orders')
            ->latest('id')
            ->paginate($per_page);

        return view ('branches.index' , compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BranchRequest $request)
    {
        $validated = $request->validated();

        Branch::create($validated);
        return redirect()->route('branches.index')->with('success', __('branches.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        return view ('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BranchRequest $request, Branch $branch)
    {

        $validated = $request->validated();
        $branch->update($validated);

        return redirect()->route('branches.index')->with('success', __('branches.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->route('branches.index')->with('success', __('branches.deleted'));
    }
}
