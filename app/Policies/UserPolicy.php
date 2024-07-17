<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains(Permission::where('title', 'user-read-all-web')->first()->id)  && !$model->role->permissions->contains(Permission::where('title', 'be_untouchable')->first()->id)) {
            return true;
        }
        elseif ($user->role && $user->id === $model->id && $user->role->permissions->contains(Permission::where('title', 'user-read-self-web')->first()->id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains(Permission::where('title', 'user-write-web')->first()->id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains(Permission::where('title', 'user-edit-all-web')->first()->id)  && !$model->role->permissions->contains(Permission::where('title', 'be_untouchable')->first()->id)) {
            return true;
        }
        elseif ($user->role && $user->id === $model->id && $user->role->permissions->contains(Permission::where('title', 'user-edit-self-web')->first()->id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains(Permission::where('title', 'user-edit-all-web')->first()->id)  && !$model->role->permissions->contains(Permission::where('title', 'be_untouchable')->first()->id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains(Permission::where('title', 'user-edit-all-web')->first()->id)  && !$model->role->permissions->contains(Permission::where('title', 'be_untouchable')->first()->id)) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains(Permission::where('title', 'user-delete-web')->first()->id)  && !$model->role->permissions->contains(Permission::where('title', 'be_untouchable')->first()->id)) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can give roles to other users
     */
    public function giveRole(User $user)
    {
        if ($user->role && $user->role->permissions->contains(Permission::where('title', 'user-give-role-web')->first()->id)) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can remove roles to other users
     */
    public function removeRole(User $user, User $model)
    {
        if ($user->role && $user->role->permissions->contains(Permission::where('title', 'user-remove-role-web')->first()->id)  && !$model->role->permissions->contains(Permission::where('title', 'be_untouchable')->first()->id)) {
            return true;
        }
        return false;
    }
}
