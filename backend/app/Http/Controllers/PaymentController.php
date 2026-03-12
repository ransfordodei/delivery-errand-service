<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display payments for an order
     */
    public function index(Order $order)
    {
        $this->authorize('view', $order);
        $payments = $order->payments()->paginate(15);

        return view('payments.index', compact('order', 'payments'));
    }

    /**
     * Show the form for making a payment
     */
    public function create(Order $order)
    {
        $this->authorize('view', $order);
        
        $totalAmount = $order->items()->sum(DB::raw('quantity * price'));
        $paidAmount = $order->payments()->where('status', 'completed')->sum('amount');
        $remainingAmount = $totalAmount - $paidAmount;

        return view('payments.create', compact('order', 'totalAmount', 'remainingAmount', 'paidAmount'));
    }

    /**
     * Store a new payment
     */
    public function store(Request $request, Order $order)
    {
        $this->authorize('view', $order);

        $data = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:momo,cod,bank_transfer',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'amount' => $data['amount'],
            'method' => $data['method'],
            'status' => 'pending',
        ]);

        return redirect()->route('payments.show', $payment)->with('success', 'Payment created. Complete the transaction.');
    }

    /**
     * Display the specified payment
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment->order);

        return view('payments.show', compact('payment'));
    }

    /**
     * Confirm payment completion
     */
    public function confirm(Request $request, Payment $payment)
    {
        $this->authorize('view', $payment->order);

        $payment->update(['status' => 'completed']);

        // Check if all payments are completed
        $order = $payment->order;
        $totalAmount = $order->items()->sum(DB::raw('quantity * price'));
        $completedAmount = $order->payments()->where('status', 'completed')->sum('amount');

        if ($completedAmount >= $totalAmount) {
            $order->update(['status' => 'paid']);
        }

        return redirect()->route('orders.show', $order)->with('success', 'Payment confirmed');
    }

    /**
     * Cancel a payment
     */
    public function destroy(Payment $payment)
    {
        $this->authorize('view', $payment->order);

        if ($payment->status === 'completed') {
            return back()->withErrors(['status' => 'Cannot cancel a completed payment']);
        }

        $payment->delete();

        return back()->with('success', 'Payment cancelled');
    }
}
