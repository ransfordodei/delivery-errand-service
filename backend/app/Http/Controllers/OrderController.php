<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of orders
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === User::ROLE_VENDOR) {
            $orders = Order::where('vendor_id', $user->vendor->id)
                ->with('user', 'rider')
                ->latest()
                ->paginate(15);
        } elseif ($user->role === User::ROLE_RIDER) {
            $orders = Order::where('rider_id', $user->rider->id)
                ->with('user', 'vendor')
                ->latest()
                ->paginate(15);
        } else {
            $orders = $user->orders()->with('vendor', 'rider')->latest()->paginate(15);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order
     */
    public function create()
    {
        $vendors = Vendor::all();
        return view('orders.create', compact('vendors'));
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'items' => 'required|array',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'delivery_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $order = Order::create([
            'user_id' => auth()->id(),
            'vendor_id' => $data['vendor_id'],
            'status' => 'pending',
            'delivery_address' => $data['delivery_address'],
            'notes' => $data['notes'] ?? null,
        ]);

        foreach ($data['items'] as $item) {
            $order->items()->create([
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->route('orders.show', $order)->with('success', 'Order created successfully');
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);
        $order->load('items', 'user', 'vendor', 'rider', 'payments');

        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the order
     */
    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        $vendors = Vendor::all();

        return view('orders.edit', compact('order', 'vendors'));
    }

    /**
     * Update the specified order
     */
    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);

        if ($order->status !== 'pending') {
            return back()->withErrors(['status' => 'Cannot update a non-pending order']);
        }

        $data = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'delivery_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $order->update($data);

        return redirect()->route('orders.show', $order)->with('success', 'Order updated successfully');
    }

    /**
     * Delete the specified order
     */
    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);

        if ($order->status !== 'pending') {
            return back()->withErrors(['status' => 'Cannot delete a non-pending order']);
        }

        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order cancelled');
    }

    /**
     * Assign a rider to an order (for vendors)
     */
    public function assignRider(Request $request, Order $order)
    {
        $this->authorize('assignRider', $order);

        $data = $request->validate([
            'rider_id' => 'required|exists:riders,id',
        ]);

        $order->update(['rider_id' => $data['rider_id'], 'status' => 'assigned']);

        return back()->with('success', 'Rider assigned successfully');
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,assigned,in_delivery,completed,cancelled',
        ]);

        $order->update(['status' => $data['status']]);

        return back()->with('success', 'Order status updated');
    }
}
