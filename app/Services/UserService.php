<?php 

namespace App\Services;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;

class UserService {
    static function findUser($id){
        $user = User::find($id);
        if(!$user)
        {
            abort(404);
        }
        return $user;
    }
    static function findTrashedUser($id)
    {
        $user = User::onlyTrashed()->find($id);
        if(!$user)
        {
            abort(404);
        }
        return $user;
    }
    static function findUserWithTrashed($id){
        $user = User::withTrashed()->find($id);
        if(!$user)
        {
            abort(404);
        }
        return $user;
    }
    static function storeUser($data){
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_key' => Str::uuid(),
            'api_access_level' => $data['api_access_level'] ?? 'NO_ACCESS'
        ]);
        return $user;
        
    }
    static function updateUser($data){
        try{
            $user = static::findUser($data['user_id']);
            $userData = [
                'name' => $data['name'] ?? null,
                'email' => $data['email'] ?? null,
                'password' => $data['password'] ? bcrypt($data['password']) : null,
                'api_key' => $data['reset_api_key'] ? Str::uuid() : null,
                'api_access_level' => $data['api_access_level'] ?? null
            ];
            $arrayForUpdate = array_filter($userData, function($value) {
                return $value !== null;
            });
            if(!empty($arrayForUpdate))
            {
                $user->update($arrayForUpdate);
            }
            return true;
        } catch(Exception $e) {
            return false;
        }
        
    }
}
