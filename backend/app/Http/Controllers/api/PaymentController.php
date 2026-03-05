<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Order;

class PaymentController extends ApiController
{
    public function store(Request $request, Order $order)
    {
        $data = $request->validate([
            'amount' => 'required|numeric',
            'method' => 'required|in:momo,cod',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'user_id' => $request->user()->id,
            'amount' => $data['amount'],
            'method' => $data['method'],
            'status' => 'pending',
        ]);

        // for momo integration we could trigger external flow here
        return response()->json($payment, 201);
    }
}
