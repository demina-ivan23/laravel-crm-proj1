<?php

namespace App\Services;

use Exception;
use App\Models\User;
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
            'role_id' => $data['role_id']
        ]);
        return $user;
    }
    static function updateUser(User $user, array $data)
    {
        try {
            $user->update([
                'name' => $data['name'] ?? $user->name,
                'email' => $data['email'] ?? $user->email,
                'password' => bcrypt($data['password'] ?? null) ?? $user->password,
                'api_key' => $data['regenerate_api_key'] ? Str::uuid()->toString() : $user->api_key,
                'role_id' => $data['role_id']
            ]);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
