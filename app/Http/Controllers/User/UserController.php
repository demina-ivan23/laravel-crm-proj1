<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //Users can only view their profiles, whereas other methods are accessible for admins only 

    public function index()
    {
        return view('users.index', User::latest()->filter()->paginate(10));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = UserService::storeUser($request->all());
        if(!$user){
            return redirect()->route('superuser.users.dashboard')->with('error', 'Something went wrong');
        } 
        return redirect()->route('superuser.users.dashboard')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $success = UserService::updateUser($user, $data);
        if(!$success)
        {
            return redirect()->route('superuser.users.dashboard')->with('error', 'Something went wrong');
        } else {
            return redirect()->route('superuser.users.dashboard')->with('success', 'User updated successfully');
        }
    }

    public function delete(User $user)
    {
        //Only soft-deleting should be in action here
        $user->delete();
        return redirect()->route('users.dashboard')->with('success', 'User trashed successfully');
    }

    //Because we use soft deletes we need one more method for restoing the user
    public function restore(User $user)
    {
        //In this case $user is searched only amongst trashed users, so if this user exists but is not trashed, 
        // an action will be aborted with 404 code;
        $user->restore();
        return redirect()->route('users.dashboard')->with('success', 'User restored successfully');
    }

    //Additionaly, if we need to delete the user permanently, we have to declare a destroy method
    //But, I think that it's unwise to implement such a feature as the team that will be working with this
    //CRM will not be big and they will barely have 100 user accounts throughout their entire usage of the app.
    // public function destroy(User $user)
    // {
    //     //Only hard-deleting should be in action here
    //     $user = UserService::findUserWithTrashed($id);
    //     $user->forceDelete();
    //     return redirect()->route('superuser.users.dashboard')->with('success', 'User deleted permanently');
    // }
}
