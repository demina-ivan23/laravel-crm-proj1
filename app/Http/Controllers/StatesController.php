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
            'order_statuses' => OrderStatus::latest()->filter()->paginate(15),
            'prospect_state' => ProspectState::latest()->filter()->paginate(15)
        ]);
    }
}
