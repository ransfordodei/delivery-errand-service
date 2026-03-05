<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class VendorController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Vendor::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->role !== User::ROLE_VENDOR) {
            abort(403);
        }
        if ($user->vendor) {
            return response()->json(['message' => 'Profile already exists'], 422);
        }
        $data = $request->validate([
            'name' => 'required|string',
            'category' => 'nullable|string',
            'description' => 'nullable|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);
        $data['user_id'] = $user->id;
        $vendor = Vendor::create($data);
        return response()->json($vendor, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Vendor::with('orders')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vendor = Vendor::findOrFail($id);
        $user = $request->user();
        if ($vendor->user_id !== $user->id) {
            abort(403);
        }
        $vendor->update($request->only(['name','category','description','phone','address']));
        return $vendor;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vendor = Vendor::findOrFail($id);
        if ($vendor->user_id !== auth()->id()) {
            abort(403);
        }
        $vendor->delete();
        return response()->json(['message' => 'Vendor profile removed']);
    }
}
