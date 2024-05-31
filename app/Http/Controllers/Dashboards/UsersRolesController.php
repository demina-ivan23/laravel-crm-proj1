<?php

namespace App\Http\Controllers\Dashboards;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersRolesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('dashboards.users-roles', ['users' => User::latest()->filter()->paginate(15), 'roles' => Role::latest()->filter()->paginate(15)]);
    }
}
