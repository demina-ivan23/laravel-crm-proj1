<?php

namespace App\Services;

use App\Models\Prospect;

class ProspectService
{
  static function getAllProspects()
  {
    $prospects = Prospect::latest('updated_at')->paginate(10);
    return $prospects;
  }
  static function getProspectById($id){
    return Prospect::find($id);
  }
  static function storeProspect($request){
    $prospect = Prospect::create($request->only('name', 'email'));

    if($request->hasFile('profile_image')) {
        $path = $request->profile_image->store('public/prospects/profiles/images'); 

         $prospect->update(['profile_image' => $path]);
       }
       $prospect->update(['state_id' => 1]);
       return $prospect;
  }
  static function deleteProspect($prospect){
   $prospect->delete();
  }
  static function updateProspect($request, $id){
    $data = $request->all();

    $prospect = static::getProspectById($id);

    if(!$prospect){
        return null;
    }

    if($request->hasFile('profile_image')){
        $path = $request->profile_image->store('public/prospects/profiles/images');
        $data['profile_image'] = $path;
    }

    $prospect->update($data);

    return $prospect;
  }

  static function setStateToLead($id){
    $prospect = static::getProspectById($id);
    $state_id = 2;
    if($prospect->state_id === null || $prospect->state_id === 1 ){
      $prospect->update(['state_id' => $state_id]);
    }
    return $prospect;
  }

  static function setStateToCustomer($id){
    $prospect = static::getProspectById($id);
    $state_id = 3;
    if($prospect->state_id === null || $prospect->state_id === 1 || $prospect->state_id === 2 ){
      $prospect->update(['state_id' => $state_id]);
    }
    return $prospect;
  }
}