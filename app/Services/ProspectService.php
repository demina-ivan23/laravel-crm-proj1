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
    $prospect = Prospect::find($id);

    return $prospect;
  }
  static function createProspect($request){
    $prospect = Prospect::create($request->only('name', 'email'));

    if($request->hasFile('profile_image')) {
        $path = $request->profile_image->store('public/prospects/profiles/images'); 

         $prospect->update(['profile_image' => $path]);
       }
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
}