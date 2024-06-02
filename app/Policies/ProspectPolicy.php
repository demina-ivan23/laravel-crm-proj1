<?php

namespace App\Policies;

use App\Models\Prospect;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProspectPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect-read-web')) {
            return true;
        }
        return false;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect-write-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect-edit-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect-edit-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect-edit-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('prospect-destroy-web')) {
            return true;
        }
        return false;
    }
}
