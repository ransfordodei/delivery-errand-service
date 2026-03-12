<?php

namespace App\Policies;

use App\Models\Rider;
use App\Models\User;

class RiderPolicy
{
    /**
     * Determine if the user can view any rider
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view a rider
     */
    public function view(User $user, Rider $rider): bool
    {
        return true;
    }

    /**
     * Determine if the user can create a rider
     */
    public function create(User $user): bool
    {
        return $user->role === User::ROLE_RIDER && !$user->rider;
    }

    /**
     * Determine if the user can update a rider
     */
    public function update(User $user, Rider $rider): bool
    {
        return $user->id === $rider->user_id;
    }

    /**
     * Determine if the user can delete a rider
     */
    public function delete(User $user, Rider $rider): bool
    {
        return $user->id === $rider->user_id;
    }
}
