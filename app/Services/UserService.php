<?php

namespace App\Services;

use Exception;
use App\Models\{
    Role, 
    Permission,
    User
};
use Illuminate\Support\Str;

class UserService
{

    static function storeUser(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_key' => Str::uuid()->toString(),
            'role_id' => Role::find($data['role_id'])->permissions->contains(Permission::where('title', 'be_untouchable')->first()->id) != true ? $data['role_id'] : ''
        ]);
        return $user;
    }
    static function updateUser(User $user, array $data)
    {
        try {
            $user->update([
                'name' => $data['name'] ?? $user->name,
                'email' => $data['email'] ?? $user->email,
                'password' => $data['password'] != null ? bcrypt($data['password']) : $user->password,
                'api_key' => $data['regenerate_api_key'] ? Str::uuid()->toString() : $user->api_key,
                'role_id' => Role::find($data['role_id'])->permissions->contains(Permission::where('title', 'be_untouchable')->first()->id) != true ? $data['role_id'] : $user->role_id
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
