<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\GroupOrder;
use App\Models\Order;

class GroupOrderController extends ApiController
{
    public function store(Request $request, Order $order)
    {
        $data = $request->validate([
            'share_amount' => 'required|numeric',
        ]);

        $group = GroupOrder::create([
            'order_id' => $order->id,
            'user_id' => $request->user()->id,
            'share_amount' => $data['share_amount'],
            'paid' => false,
        ]);

        return response()->json($group, 201);
    }
}
