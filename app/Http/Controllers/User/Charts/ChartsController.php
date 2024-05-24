<?php

namespace App\Http\Controllers\User\Charts;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ChartsService;
use App\Http\Controllers\Controller;

class ChartsController extends Controller
{
    public function index()
    {
        $routeName = request()->route()->getName();
        $str_array = explode('.', $routeName);
        $viewName = $str_array[count($str_array)-1];
        $data = ChartsService::getDashboardData(request()->query());
        return view('user.charts.' . $viewName, ['data' => $data]);
    }

}