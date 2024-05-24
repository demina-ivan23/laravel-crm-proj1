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
        ]);
        return $user;
        
    }
    static function updateUser($user, $data){
        try{
            $user->update($data);
            return true;
        } catch(Exception $e) {
            return false;
        }
        
    }
}
