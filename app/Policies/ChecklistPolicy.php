<?php

namespace App\Policies;

use App\Models\Checklist;
use App\Models\User;

class ChecklistPolicy
{
    public function view(User $user, Checklist $checklist)
    {
        return $user->isAdmin() || 
               $user->id === $checklist->housekeeper_id ||
               $user->id === $checklist->property->owner_id;
    }

    public function update(User $user, Checklist $checklist)
    {
        return $user->id === $checklist->housekeeper_id;
    }
}
