<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\SuperadminService;
use App\Http\Controllers\Controller;

class SuperadminController extends Controller
{
    //superadmins can view and edit ther profile, can access dashboard
    public function index()
    {
        $data = SuperadminService::getDashboardData(request()->query());
        if(request()->route()->getName() == 'superadmin.index'){
            return view('superadmin.index', ['data' => $data]);
        } elseif(request()->routeIs('superadmin.order_product_chart')) {
            return view('superadmin.charts.order_product_chart', ['data' => $data]);
        } elseif(request()->routeIs('superadmin.order_prospect_chart')) {
            return view('superadmin.charts.order_prospect_chart', ['data' => $data]);
        }
    }

    public function show(string $id)
    {
        return view('superadmin.show', ['superadmin' => UserService::findUser($id)]);
    }


    public function edit(string $id)
    {
        return view('superadmin.edit', ['superadmin' => UserService::findUser($id)]);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $data['superadmin_id'] = $id;
        $success = SuperadminService::update($data);
        if (!$success) {
            return redirect()->route('superadmin.index')->with('success', 'Profile updated successfully');
        } else {
            return redirect()->route('superadmin.index')->with('error', 'Something went wrong');
        }
    }
}
