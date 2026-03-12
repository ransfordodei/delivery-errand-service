<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Models\User;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of vendors
     */
    public function index()
    {
        $vendors = Vendor::paginate(15);
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a vendor profile
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role !== User::ROLE_VENDOR) {
            return back()->withErrors(['role' => 'Only vendors can create a vendor profile']);
        }

        if ($user->vendor) {
            return redirect()->route('vendors.edit', $user->vendor);
        }

        return view('vendors.create');
    }

    /**
     * Store a newly created vendor
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->role !== User::ROLE_VENDOR) {
            return back()->withErrors(['role' => 'Only vendors can create a vendor profile']);
        }

        if ($user->vendor) {
            return back()->withErrors(['vendor' => 'You already have a vendor profile']);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $data['user_id'] = $user->id;
        Vendor::create($data);

        return redirect()->route('vendors.show', $user->vendor)->with('success', 'Vendor profile created');
    }

    /**
     * Display the specified vendor
     */
    public function show(Vendor $vendor)
    {
        $vendor->load('orders');
        return view('vendors.show', compact('vendor'));
    }

    /**
     * Show the form for editing the vendor
     */
    public function edit(Vendor $vendor)
    {
        $this->authorize('update', $vendor);
        return view('vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified vendor
     */
    public function update(Request $request, Vendor $vendor)
    {
        $this->authorize('update', $vendor);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $vendor->update($data);

        return redirect()->route('vendors.show', $vendor)->with('success', 'Vendor updated successfully');
    }

    /**
     * Delete the vendor profile
     */
    public function destroy(Vendor $vendor)
    {
        $this->authorize('delete', $vendor);

        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'Vendor profile deleted');
    }
}
