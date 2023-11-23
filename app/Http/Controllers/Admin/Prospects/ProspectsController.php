<?php

namespace App\Http\Controllers\Admin\Prospects;

use App\Models\Prospect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Prospects\StoreProspectRequest;

class ProspectsController extends Controller

{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.prospects.index', ['prospects' => Prospect::latest()->paginate(10)]);
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
       $prospect = Prospect::create($request->only('name', 'email'));

       if($request->hasFile('profile_image')) {
         $path = $request->profile_image->store('public/prospects/profiles/images');      
         $prospect->update(['profile_image' => $path]);
       }

        return redirect()->route('admin.prospects.dashboard')->with('success', 'Prospect created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Prospect $prospect)
    {
       return view('admin.prospects.show', ['prospect' => $prospect]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prospect $prospect)
    {
        return view('admin.prospects.edit', ['prospect' => $prospect]);
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
