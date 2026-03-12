<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the dashboard
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $stats = [];

        if ($user->role === User::ROLE_USER) {
            $stats['total_orders'] = $user->orders()->count();
            $stats['pending_orders'] = $user->orders()->where('status', 'pending')->count();
            $stats['completed_orders'] = $user->orders()->where('status', 'completed')->count();
            $orders = $user->orders()->with('vendor', 'rider')->latest()->paginate(10);
            return view('dashboard.customer', compact('stats', 'orders'));
        }

        if ($user->role === User::ROLE_VENDOR) {
            $vendor = $user->vendor;
            $stats['total_orders'] = Order::where('vendor_id', $vendor->id)->count();
            $stats['pending_orders'] = Order::where('vendor_id', $vendor->id)->where('status', 'pending')->count();
            $stats['completed_orders'] = Order::where('vendor_id', $vendor->id)->where('status', 'completed')->count();
            $orders = Order::where('vendor_id', $vendor->id)->with('user', 'rider')->latest()->paginate(10);
            return view('dashboard.vendor', compact('vendor', 'stats', 'orders'));
        }

        if ($user->role === User::ROLE_RIDER) {
            $rider = $user->rider;
            $stats['total_deliveries'] = Order::where('rider_id', $rider->id)->count();
            $stats['pending_deliveries'] = Order::where('rider_id', $rider->id)->where('status', 'in_delivery')->count();
            $stats['completed_deliveries'] = Order::where('rider_id', $rider->id)->where('status', 'completed')->count();
            $orders = Order::where('rider_id', $rider->id)->with('user', 'vendor')->latest()->paginate(10);
            return view('dashboard.rider', compact('rider', 'stats', 'orders'));
        }

        return view('dashboard.index', compact('stats'));
    }
}
