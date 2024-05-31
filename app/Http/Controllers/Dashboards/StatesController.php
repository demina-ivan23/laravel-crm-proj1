<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use App\Models\ProspectState;
use Illuminate\Http\Request;

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
