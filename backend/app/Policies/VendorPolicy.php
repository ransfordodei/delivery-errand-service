<?php

namespace App\Policies;

use App\Models\Vendor;
use App\Models\User;

class VendorPolicy
{
    /**
     * Determine if the user can view any vendor
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view a vendor
     */
    public function view(User $user, Vendor $vendor): bool
    {
        return true;
    }

    /**
     * Determine if the user can create a vendor
     */
    public function create(User $user): bool
    {
        return $user->role === User::ROLE_VENDOR && !$user->vendor;
    }

    /**
     * Determine if the user can update a vendor
     */
    public function update(User $user, Vendor $vendor): bool
    {
        return $user->id === $vendor->user_id;
    }

    /**
     * Determine if the user can delete a vendor
     */
    public function delete(User $user, Vendor $vendor): bool
    {
        return $user->id === $vendor->user_id;
    }
}
