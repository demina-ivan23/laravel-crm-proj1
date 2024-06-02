<?php

namespace App\Policies;

use App\Models\ProspectState;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProspectStatePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect_state-read-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect_state-write-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect_state-edit-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect_state-edit-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect_state-edit-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect_state-destroy-web')) {
            return true;
        }
        return false;
    }
}
