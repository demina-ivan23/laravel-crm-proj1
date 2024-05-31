<?php

namespace App\Http\Controllers\Dashboards;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use App\Models\ProspectState;
use App\Http\Controllers\Controller;

class StatesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return view('dashboards.states', [
            'orderStatuses' => OrderStatus::paginate(15),
            'prospectStates' => ProspectState::paginate(15)
        ]);
    }
}
