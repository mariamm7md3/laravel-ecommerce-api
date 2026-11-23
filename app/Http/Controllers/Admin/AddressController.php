<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
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
    public function create(User $user)
    {
        return view('addresses.create' , compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request , User $user)
    {
        $validated = $request->validated();

        if($request->boolean('is_main'))
        {
            $user->addresses()->update(['is_main' => false]);
        }

        $user->addresses()->create($validated);

        return redirect()->route('users.show', $user)->with('success', 'Address added successfully.');
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
    public function edit(Address $address)
    {
        return view('addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressRequest $request, Address $address)
    {
        $validated = $request->validated();

        if($request->boolean('is_main'))
        {
            $address->user->addresses()
                ->where('id', '!=', $address->id)
                ->update(['is_main' => false]);
        }

        $address->update($validated);

        return redirect()->route('users.show', $address->user)->with('success', 'Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return back()->with('success', 'Address deleted successfully.');
    }

    public function toggleStatus(Address $address)
    {
        $address->update([
            'is_active' => !$address->is_active,
        ]);

        return back()->with('success', 'Address status updated.');
    }
}
