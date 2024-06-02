<?php

namespace App\Http\Controllers\Dashboards;


use App\Services\ChartsService;
use App\Http\Controllers\Controller;

class ChartsController extends Controller
{
    public function index()
    {
        $data = ChartsService::getDashboardData(request()->query());
        return view('dashboards.order-charts', ['data' => $data]);
    }

}