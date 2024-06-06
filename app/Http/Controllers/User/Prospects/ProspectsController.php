<?php

namespace App\Http\Controllers\User\Prospects;

use App\Models\Prospect;
use App\Services\ProspectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Prospects\{
    StoreProspectRequest,
    UpdateProspectRequest
};

class ProspectsController extends Controller

{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = ProspectService::getAllStates();
        $prospects = ProspectService::getAllProspects();
        return view('user.prospects.index', compact('prospects', 'states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.prospects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProspectRequest $request)
    {
        $prospect = ProspectService::storeProspect($request->all());
        return redirect()->route('dashboards.prospects-products-orders', ['tablink' => 'prospects', 'tab-button' => 'prospectsTabButton'])->with('success', 'Prospect created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prospect $prospect)
    {
        if (request()->routeIs('user.prospects.show')) {
            return view('user.prospects.show', compact('prospect'));
        } elseif (request()->routeIs('user.prospects.show-orders')) {
            $orders = $prospect->orders()->latest()->paginate(5);
            return view('user.prospects.show-orders', compact('prospect', 'orders'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prospect $prospect)
    {
        return view('user.prospects.edit', compact('prospect'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProspectRequest $request, Prospect $prospect)
    {
        $prospect = ProspectService::updateProspect($request->all(), $prospect);
        if ($prospect) {
            return redirect()->route('dashboards.prospects-products-orders', ['tablink' => 'prospects', 'tab-button' => 'prospectsTabButton'])->with('success', 'Prospect "' . $prospect->name . '" updated successfully');
        } else {
            return redirect()->route('dashboards.prospects-products-orders', ['tablink' => 'prospects', 'tab-button' => 'prospectsTabButton'])->with('error', 'Sorry, something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Prospect $prospect){
        $prospect->delete();
        return redirect()->route('dashboards.prospects-products-orders', ['tablink' => 'prospects', 'tab-button' => 'prospectsTabButton'])->with('success', 'Prospect Trashed Successfully');
    }
    public function restore(string $id){
        $prospect = Prospect::withTrashed()->find($id);
        $prospect->restore();
        return redirect()->route('dashboards.prospects-products-orders', ['tablink' => 'prospects', 'tab-button' => 'prospectsTabButton'])->with('success', 'Prospect Restored Successfully');
    }
    public function destroy(string $id)
    {
        $prospect = Prospect::withTrashed()->find($id);
        $prospect->forceDelete();
        return redirect()->route('dashboards.prospects-products-orders', ['tablink' => 'prospects', 'tab-button' => 'prospectsTabButton'])->with('success', 'Prospect Deleted Permanently');
    }
}