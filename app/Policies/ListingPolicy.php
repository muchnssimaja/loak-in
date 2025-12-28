<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{
    public function update(User $user, Listing $listing): bool
    {
        return $listing->user_id === $user->id || $user->is_admin;
    }

    public function delete(User $user, Listing $listing): bool
    {
        return $listing->user_id === $user->id || $user->is_admin;
    }
}
