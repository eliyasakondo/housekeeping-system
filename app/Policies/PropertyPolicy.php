<?php

namespace App\Policies;

use App\Models\Property;
use App\Models\User;

class PropertyPolicy
{
    public function view(User $user, Property $property)
    {
        return $user->isAdmin() || $user->id === $property->owner_id;
    }

    public function update(User $user, Property $property)
    {
        return $user->isAdmin() || $user->id === $property->owner_id;
    }

    public function delete(User $user, Property $property)
    {
        return $user->isAdmin() || $user->id === $property->owner_id;
    }
}
