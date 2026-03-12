<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;

class PaymentPolicy
{
    /**
     * Determine if the user can view the payment
     */
    public function view(User $user, Payment $payment): bool
    {
        $order = $payment->order;
        return $user->id === $order->user_id || 
               ($user->vendor && $user->vendor->id === $order->vendor_id) ||
               ($user->rider && $user->rider->id === $order->rider_id);
    }

    /**
     * Determine if the user can create a payment
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can delete a payment
     */
    public function delete(User $user, Payment $payment): bool
    {
        return $user->id === $payment->user_id && $payment->status === 'pending';
    }
}
