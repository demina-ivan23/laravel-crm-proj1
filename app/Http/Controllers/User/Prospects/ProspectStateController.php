<?php

namespace App\Http\Controllers\User\Prospects;

use Illuminate\Http\Request;
use App\Models\ProspectState;
use App\Http\Controllers\Controller;
use App\Services\ProspectStateService;
use App\Http\Requests\ProspectState\StoreProspectStateRequest;
use App\Http\Requests\ProspectState\UpdateProspectStateRequest;

class ProspectStateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.prospect_states.index', ['prospectStates' => ProspectState::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.prospect_states.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProspectStateRequest $request)
    {
        $result = ProspectStateService::storeProspectState($request->all());
        if (str_contains($result, 'successfully')) {
            return redirect()->route('user.prospect_states.index')->with('success', $result);
        } else {
            return redirect()->route('user.prospect_states.create')->with('error', $result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProspectState $prospectState)
    {
        $routeName = request()->route()->getName();
        if ($routeName == 'user.prospect_states.edit') {
            return view('user.prospect_states.edit', compact('prospectState'));
        } elseif ($routeName == 'user.prospect_states.edit_via_table') {
            return view('user.prospect_states.edit_via_table', ['prospectStates' => ProspectState::all()]);
        } else {
            dd($routeName);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProspectStateRequest $request, ProspectState $prospectState)
    {
        $result = ProspectStateService::updateProspectState($request->all(), $prospectState);
        if (str_contains($result, 'successfully')) {
            return redirect()->route('user.prospect_states.index')->with('success', $result);
        } else {
            return redirect()->route('user.prospect_states.edit', compact('prospectState'))->with('error', $result);
        }
    }
    public function updateAll(Request $request)
    {
        $result = ProspectStateService::updateProspectStatesViaTable($request->all());
        if (str_contains($result, 'successfully')) {
            return redirect()->route('user.prospect_states.index')->with('success', $result);
        } else {
            return redirect()->route('user.prospect_states.edit_via_table')->with('error', $result);
        }
    }
}
