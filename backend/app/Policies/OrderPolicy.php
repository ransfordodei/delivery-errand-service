<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine if the user can view the order
     */
    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id || 
               ($user->vendor && $user->vendor->id === $order->vendor_id) ||
               ($user->rider && $user->rider->id === $order->rider_id);
    }

    /**
     * Determine if the user can create orders
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the order
     */
    public function update(User $user, Order $order): bool
    {
        return $user->id === $order->user_id;
    }

    /**
     * Determine if the user can delete the order
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->id === $order->user_id && $order->status === 'pending';
    }

    /**
     * Determine if the user can assign a rider
     */
    public function assignRider(User $user, Order $order): bool
    {
        return $user->vendor && $user->vendor->id === $order->vendor_id;
    }
}
