<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Tests\Feature\GeneralTest;
use App\Models\TimeTakenForOrder;
use Illuminate\Support\Facades\Artisan;

class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $timeTakenArray = TimeTakenForOrder::all();
        return view('admin.graphs.index', ['timeTakenArray' => $timeTakenArray]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
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
