<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);

        $users = User::query()
            ->where('is_admin',false)
            ->withCount('orders')
            ->adminFilter($request)
            ->latest()
            ->paginate($per_page)
            ->withQueryString();

        return view('users.index' , compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();

        if($request->hasFile('photo')){
            $validated['photo'] = $this->uploadImage($request->file('photo') ,'users');
        }

        $user = User::create($validated);

        return redirect()
            ->route('users.index')
            ->with('success' , 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('addresses');
//        dd($user->addresses());

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        if($request->hasFile('photo'))
        {
            $validated['photo'] = $this->updateImage($request->file('photo'), $user->photo, 'users');
        }

        if ($request->filled('password')) {
            $validated['password'] = $request->password;
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('users.show' , $user)
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $user->is_active,
        ]);
    }

}
