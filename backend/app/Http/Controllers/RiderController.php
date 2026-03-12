<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use App\Models\User;
use Illuminate\Http\Request;

class RiderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of riders
     */
    public function index()
    {
        $riders = Rider::paginate(15);
        return view('riders.index', compact('riders'));
    }

    /**
     * Show the form for creating a rider profile
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role !== User::ROLE_RIDER) {
            return back()->withErrors(['role' => 'Only riders can create a rider profile']);
        }

        if ($user->rider) {
            return redirect()->route('riders.edit', $user->rider);
        }

        return view('riders.create');
    }

    /**
     * Store a newly created rider profile
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== User::ROLE_RIDER) {
            return back()->withErrors(['role' => 'Only riders can create a rider profile']);
        }

        if ($user->rider) {
            return back()->withErrors(['rider' => 'You already have a rider profile']);
        }

        $data = $request->validate([
            'phone' => 'nullable|string|max:20',
            'vehicle_type' => 'nullable|string|max:50',
        ]);

        $data['user_id'] = $user->id;
        $data['status'] = 'available';
        
        Rider::create($data);

        return redirect()->route('riders.show', $user->rider)->with('success', 'Rider profile created');
    }

    /**
     * Display the specified rider
     */
    public function show(Rider $rider)
    {
        $rider->load('orders');
        return view('riders.show', compact('rider'));
    }

    /**
     * Show the form for editing the rider
     */
    public function edit(Rider $rider)
    {
        $this->authorize('update', $rider);
        return view('riders.edit', compact('rider'));
    }

    /**
     * Update the specified rider
     */
    public function update(Request $request, Rider $rider)
    {
        $this->authorize('update', $rider);

        $data = $request->validate([
            'phone' => 'nullable|string|max:20',
            'vehicle_type' => 'nullable|string|max:50',
            'status' => 'nullable|in:available,busy,offline',
        ]);

        $rider->update($data);

        return redirect()->route('riders.show', $rider)->with('success', 'Rider profile updated');
    }

    /**
     * Delete the rider profile
     */
    public function destroy(Rider $rider)
    {
        $this->authorize('delete', $rider);

        $rider->delete();

        return redirect()->route('riders.index')->with('success', 'Rider profile deleted');
    }

    /**
     * Update rider status
     */
    public function updateStatus(Request $request, Rider $rider)
    {
        $this->authorize('update', $rider);

        $data = $request->validate([
            'status' => 'required|in:available,busy,offline',
        ]);

        $rider->update($data);

        return back()->with('success', 'Status updated');
    }
}
