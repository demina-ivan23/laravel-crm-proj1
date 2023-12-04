<?php

namespace App\Http\Controllers\Admin\Prospects;

use App\Models\Prospect;
use Illuminate\Http\Request;
use App\Services\ProspectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Prospects\StoreProspectRequest;
use App\Http\Requests\Prospects\UpdateProspectRequest;

class ProspectsController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $prospects = ProspectService::getAllProspects();
        return view('admin.prospects.index', ['prospects' => $prospects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.prospects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProspectRequest $request)
    { 
                  
        $prospect = ProspectService::storeProspect($request);
        return redirect()->route('admin.prospects.contacts.create', ['prospect' => $prospect])->with('success', 'Prospect created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $prospect = ProspectService::getProspectById($id);
       return view('admin.prospects.show', ['prospect' => $prospect]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    { 
        $prospect = ProspectService::getProspectById($id);
        return view('admin.prospects.edit', ['prospect' => $prospect]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProspectRequest $request, string $id)
    {
        $prospect = ProspectService::updateProspect($request, $id);
        if($prospect){

            return redirect('/prospects/prospects')->with('success', 'Prospect "' . $prospect->name . '" updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $prospect = ProspectService::getProspectById($id);

        if(!$prospect){
            return response()->json(['message' => 'Prospect not found'], 404);
        }

        ProspectService::deleteProspect($prospect);
        return redirect('/prospects/prospects');
    }
}
