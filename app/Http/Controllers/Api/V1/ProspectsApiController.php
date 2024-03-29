<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Prospect;
use Illuminate\Http\Request;
use App\Services\ProspectService;
use App\Http\Controllers\Controller;
use App\Mappers\DTOMapper;
use Database\Seeders\ProspectSeeder;

class ProspectsApiController extends Controller
{
  /**
     * Display a listing of the resource.
*/
    public function index()
    {
       $prospects = ProspectService::getAllProspects(); // it shows the latest prospects first
       return response()->json(['prospects' => $prospects]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $prospect = ProspectService::storeProspect($request->all());
        if($prospect){
            return response()->json(['result' => 'Prospect Created Successfully', 'prospect' => $prospect]);
        } else {
            return response()->json(['result' => 'Prospect Creation Failed']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $prospect = ProspectService::findProspect($id);
        return response()->json(['prospect' => $prospect]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $data['prospect_id'] = $id;
        $prospect = ProspectService::updateProspect($data);
        if($prospect){
            return response()->json(['result'=>'Prospect updated successfully', 'prospect' => $prospect]);
        } else {
            return response()->json(['result'=>'Something went wrong']);  
        }
    }

    // public function destroy(string $id)
    // {
    //     //some space for soft deletes
    // }
}
