<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderStatusPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if($user->role && $user->role->permissions->contains('order_status-read-web')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->role && $user->role->permissions->contains('order_status-write-web')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if($user->role && $user->role->permissions->contains('order_status-edit-web')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        if($user->role && $user->role->permissions->contains('order_status-edit-web')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        if($user->role && $user->role->permissions->contains('order_status-edit-web')){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        if($user->role && $user->role->permissions->contains('order_status-destroy-web')){
            return true;
        }
        return false;
    }
}
