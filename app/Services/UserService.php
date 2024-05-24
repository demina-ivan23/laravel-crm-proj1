<?php 

namespace App\Services;
use Exception;
use App\Models\User;
use Illuminate\Support\Str;

class UserService {
    static function storeUser(array $data){
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_key' => Str::uuid(),
        ]);
        return $user;
        
    }
    static function updateUser(User $user, array $data){
        try{
            $user->update($data);
            return true;
        } catch(Exception $e) {
            return false;
        }
        
    }
}
