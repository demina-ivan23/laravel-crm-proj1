<?php

namespace App\Http\Controllers\Admin\Prospects;

use App\Models\Prospect;
use Illuminate\Http\Request;
use App\Services\ProspectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Prospects\StoreProspectContactRequest;

class ProspectsContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Prospect $prospect)
    {
        
        return view('admin.prospects.contacts.create', ['prospect' => $prospect]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProspectContactRequest $request, $id)
    {
        ProspectService::storeProspectContact($id, $request);
        return redirect('/prospects/prospects');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $prospect = ProspectService::getProspectById($id);
        return view('admin.prospects.contacts.edit', ['prospect' => $prospect]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
