<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains('user-read-all-web') && !$model->role->permissions->contains('be_untouchable')) {
            return true;
        } elseif($user->role && $user->id === $model->id && $user->role->permissions->contains('user-read-self-web')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->role && $user->role->permissions->contains('user-write-web')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains('user-edit-all-web') && !$model->role->permissions->contains('be_untouchable')) {
            return true;
        } elseif($user->role && $user->id === $model->id && $user->role->permissions->contains('user-edit-self-web')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains('user-edit-all-web') && !$model->role->permissions->contains('be_untouchable')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains('user-edit-all-web') && !$model->role->permissions->contains('be_untouchable')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        if ($user->role && $user->role->permissions->contains('user-destroy-web') && !$model->role->permissions->contains('be_untouchable')) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can give roles to other users
     */
    public function giveRole(User $user, User $model){
        if ($user->role && $user->role->permissions->contains('user-give-role-web') && !$model->role->permissions->contains('be_untouchable') && $user->id !== $model->id) {
            return true;
        }
        return false;
    }
    /**
     * Determine whether the user can remove roles to other users
     */
    public function removeRole(User $user, User $model){
        if ($user->role && $user->role->permissions->contains('user-remove-role-web') && !$model->role->permissions->contains('be_untouchable') && $user->id !== $model->id) {
            return true;
        }
        return false;
    }
}
