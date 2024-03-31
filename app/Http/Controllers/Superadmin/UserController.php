<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //Users can only view their profiles, whereas other methods are accessible for superadmins only 

    public function index()
    {
        return view('superadmin.users.index', ['users' => User::latest()->get()]);
    }

    public function create()
    {
        return view('superadmin.users.create');
    }

    public function store(Request $request)
    {
        $user = UserService::storeUser($request->all());
        if(!$user){
            return redirect()->route('superadmin.users.dashboard')->with('error', 'Something went wrong');
        } 
        return redirect()->route('superadmin.users.dashboard')->with('success', 'User created successfully');
    }

    public function show(string $id)
    {
        return view('superadmin.users.show', ['user' => UserService::findUser($id)]);
    }

    public function edit(string $id)
    {
        return view('superadmin.users.edit', ['user' => UserService::findUser($id)]);
    }
    
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $data['user_id'] = $id;
        $success = UserService::updateUser($data);
        if(!$success)
        {
            return redirect()->route('superadmin.users.dashboard')->with('error', 'Something went wrong');
        } else {
            return redirect()->route('superadmin.users.dashboard')->with('success', 'User updated successfully');
        }
    }

    public function delete(string $id)
    {
        //Only soft-deleting should be in action here
        $user = UserService::findUser($id);
        $user->delete();
        return redirect()->route('superadmin.users.dashboard')->with('success', 'User trashed successfully');
    }

    //Because we use soft deletes we need one more method for restoing the user
    public function restore(string $id)
    {
        $user = UserService::findTrashedUser($id);
        //In this case $user is searched only amongst trashed users, so if this user exists but is not trashed, 
        // an action will be aborted with 404 code;
        $user->restore();
        return redirect()->route('superadmin.users.dashboard')->with('success', 'User restored successfully');
    }

    //Additionaly, if we need to delete the user permanently, we have to declare a destroy method
    //But, I think that it's unwise to implement such a feature as the team that will be working with this
    //CRM will not be big and they will barely have 100 user accounts throughout their entire usage of the app.
    // public function destroy(string $id)
    // {
    //     //Only hard-deleting should be in action here
    //     $user = UserService::findUserWithTrashed($id);
    //     $user->forceDelete();
    //     return redirect()->route('superadmin.users.dashboard')->with('success', 'User deleted permanently');
    // }
}
