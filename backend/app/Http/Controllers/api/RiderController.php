<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Rider;
use App\Models\User;

class RiderController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Rider::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        if ($user->role !== User::ROLE_RIDER) {
            abort(403);
        }
        if ($user->rider) {
            return response()->json(['message' => 'Profile already exists'], 422);
        }
        $data = $request->validate([
            'phone' => 'nullable|string',
            'vehicle_type' => 'nullable|string',
        ]);
        $data['user_id'] = $user->id;
        $rider = Rider::create($data);
        return response()->json($rider, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Rider::with('orders')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rider = Rider::findOrFail($id);
        if ($rider->user_id !== $request->user()->id) {
            abort(403);
        }
        $rider->update($request->only(['phone','vehicle_type','status']));
        return $rider;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rider = Rider::findOrFail($id);
        if ($rider->user_id !== auth()->id()) {
            abort(403);
        }
        $rider->delete();
        return response()->json(['message' => 'Rider profile removed']);
    }
}
