<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\Rider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->role === User::ROLE_VENDOR) {
            return $user->vendor->orders()->with('user','rider')->get();
        }
        if ($user->role === User::ROLE_RIDER) {
            return Order::where('rider_id', $user->rider->id)->with('user','vendor')->get();
        }
        // regular users see own orders
        return $user->orders()->with('vendor','rider')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => 'nullable|exists:vendors,id',
            'items_description' => 'required|string',
            'notes' => 'nullable|string',
            'delivery_address' => 'required|string',
            'total_cost' => 'required|numeric',
        ]);

        $order = Order::create(array_merge($data, ['user_id' => $request->user()->id]));
        return response()->json($order, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with('items','payments','groupOrders')->findOrFail($id);
        $user = auth()->user();
        if ($user->role === User::ROLE_ADMIN ||
            $order->user_id === $user->id ||
            ($user->role === User::ROLE_VENDOR && $order->vendor_id === $user->vendor->id) ||
            ($user->role === User::ROLE_RIDER && $order->rider_id === $user->rider->id)) {
            return $order;
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $user = $request->user();

        // status updates allowed depending on role
        if ($request->has('status')) {
            $status = $request->input('status');
            // validation of status transitions simplified
            if ($user->role === User::ROLE_VENDOR && $order->vendor_id === $user->vendor->id) {
                $order->status = $status;
            } elseif ($user->role === User::ROLE_RIDER && $order->rider_id === $user->rider->id) {
                $order->status = $status;
            } elseif ($user->id === $order->user_id) {
                // allow cancel when pending
                if ($status === 'cancelled' && $order->status === 'pending') {
                    $order->status = 'cancelled';
                } else {
                    abort(403);
                }
            } else {
                abort(403);
            }
            $order->save();
        }
        return $order;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $user = auth()->user();
        if ($user->id === $order->user_id && $order->status === 'pending') {
            $order->delete();
            return response()->json(['message' => 'Order cancelled']);
        }
        abort(403);
    }
}
