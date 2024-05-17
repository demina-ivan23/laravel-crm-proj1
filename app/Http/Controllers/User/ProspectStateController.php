<?php

namespace App\Http\Controllers\User;

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
        return view('admin.prospect_states.index', ['prospectStates' => ProspectState::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.prospect_states.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProspectStateRequest $request)
    {
        $result = ProspectStateService::storeProspectState($request->all());
        if (str_contains($result, 'successfully')) {
            return redirect()->route('admin.prospect_states.index')->with('success', $result);
        } else {
            return redirect()->route('admin.prospect_states.create')->with('error', $result);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProspectState $prospectState)
    {
        return view('admin.prospect_states.edit', compact('prospectState'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProspectStateRequest $request, ProspectState $prospectState)
    {
        $result = ProspectStateService::updateProspectState($request->all(), $prospectState);
        if (str_contains($result, 'successfully')) {
            return redirect()->route('admin.prospect_states.index')->with('success', $result);
        } else {
            return redirect()->route('admin.prospect_states.edit', compact('prospectState'))->with('error', $result);
        }
    }
}
