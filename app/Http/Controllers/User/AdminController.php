<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AdminService;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //Admins can view and edit ther profile, can access dashboard
    public function index()
    {
        $routeName = request()->route()->getName();
        $str_array = explode('.', $routeName);
        $viewName = $str_array[count($str_array)-1];
        $data = AdminService::getDashboardData(request()->query());
        if($viewName != 'index'){
            return view('admin.charts.' . $viewName, ['data' => $data]);
        }
        return view('admin.index');
    }

    public function show(string $id)
    {
        return view('admin.show', ['Admin' => UserService::findUser($id)]);
    }


    public function edit(string $id)
    {
        return view('admin.edit', ['Admin' => UserService::findUser($id)]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $data['Admin_id'] = $id;
        $success = AdminService::update($data);
        if (!$success) {
            return redirect()->route('admin.index')->with('success', 'Profile updated successfully');
        } else {
            return redirect()->route('admin.index')->with('error', 'Something went wrong');
        }
    }
}
