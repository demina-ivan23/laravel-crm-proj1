<?php

namespace App\Services;

use App\Models\CustomerState;
use App\Models\Prospect;

class ProspectService
{
  static function getAllProspects(){
    $prospects = Prospect::latest()->get();
    return $prospects;
  }
  static function getAllFilteredProspects()
  {
    $prospects = Prospect::latest()->filter()->get();
    return $prospects;
  }
  static function getAllStates(){
    $states = CustomerState::all();
    return $states;
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
    if($data['custom_state']){
      
      $state_id = static::getOrCreateCustomStateId($data['custom_state']);
      unset($data['custom_state']);
     
      $data['state_id'] = $state_id;
    }
    else{
      unset($data['custom_state']);
      
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

  static function getOrCreateCustomStateId($state){
    $custom_state = CustomerState::where('title', $state)->first();

    if (!$custom_state) {
        $custom_state = CustomerState::create(['title' => $state]);
        return $custom_state->id;
    }
    
    return $custom_state->id;
    
  }

  static function getCustomStateTitle($id){
    $state = CustomerState::find($id);
    if($state){
      return $state->title;
    }
    else{
      return 'undefined';
    }
  }

  static function storeProspectContact($id, $request)
  {
    $prospect = static::getProspectById($id);
    $data = $request->all();
    $data = $request->all();
       if($data['custom_state']){
        $state_id = static::getOrCreateCustomStateId($data['custom_state']);
        unset($data['custom_state']);
        $prospect->update(['state_id' => $state_id]);
       }
       else{
        unset($data['custom_state']);
        $prospect->update(['state_id' => 2]);
       }
    $prospect->update($data);
    static::setStateToLead($prospect->id);
    return $prospect;
  }

}