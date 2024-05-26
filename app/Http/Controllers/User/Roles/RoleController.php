<?php

namespace App\Http\Controllers\User\Roles;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.roles.index', ['roles' => Role::latest()->filter()->paginate(20)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = RoleService::storeRole($request->all());
        $session = str_contains($result, 'successful') ? 'success' : 'error';
        return redirect()->route('user.roles.dashboard')->with($session, $result);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return view('user.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('user.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $result = RoleService::updateRole($role, $request->all());
        $session = str_contains($result, 'successful') ? 'success' : 'error';
        return redirect()->route('user.roles.dashboard')->with($session, $result);
    }

    public function delete(Role $role)
    {
        $role->delete();
        return redirect()->route('user.roles.dashboard')->with('success', 'Role Trashed Successfully');
    }
}
