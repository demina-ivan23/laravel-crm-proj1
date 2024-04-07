<?php

namespace App\Services;

use App\Models\Prospect;
use App\Models\ProspectState;
use App\Models\ProspectStateTransitionTracking;

class ProspectService
{
  static function getAllProspects()
  {
    $prospects = Prospect::latest()->filter()->paginate(15);
    return $prospects;
  }
  static function getAllStates()
  {
    $states = ProspectState::all();
    return $states;
  }
  static function storeProspect($data)
  {
    $prospectData = [
      'name' => $data['name'],
      'email' => $data['email'],
      'phone_number' => $data['phone_number'] ?? null,
      'facebook_account' => $data['facebook_account'] ?? null,
      'instagram_account' => $data['instagram_account'] ?? null,
      'address' => $data['adress'] ?? null,
      'personal_info' => $data['personal_info'] ?? null,
    ];
    $prospect = Prospect::create($prospectData);
    unset($prospectData['name'], $prospectData['email']);
    $additionalInfoIsNull = empty(array_filter($prospectData, function ($value) {
      return $value !== null;
    }));
      $state_id = $additionalInfoIsNull ? 1 : 2;
    $prospect->update(['state_id' => $state_id]);
    $custom_state = $data['custom_prospect_state'] ?? null;
    $state = $data['prospect_state'] ?? null;
    static::setCustomProspectState($state, $custom_state, $prospect);
    static::createStateTransitionObject($prospect);
    return $prospect;
  }
  static function deleteProspect($prospect)
  {
    $prospect->delete();
  }
  static function updateProspect($data)
  {
    $prospect = static::findProspect($data['prospect_id']);
    if (!$prospect) {
      return null;
    }
    $prospectData = [
      'name' => $data['name'] ?? null,
      'email' => $data['email'] ?? null,
      'phone_number' => $data['phone_number'] ?? null,
      'facebook_account' => $data['facebook_account'] ?? null,
      'instagram_account' => $data['instagram_account'] ?? null,
      'address' => $data['adress'] ?? null,
      'personal_info' => $data['personal_info'] ?? null,
    ];
    $arrayForUpdate = array_filter($prospectData, function ($value) {
      return $value !== null;
    });
    $prospect->update($arrayForUpdate);
    unset($arrayForUpdate['name'], $arrayForUpdate['email']);
    $additionalInfoIsNull = empty($arrayForUpdate);
    $state_id = 1;
    if ($prospect->state_id === 1 && !$additionalInfoIsNull) {
      $state_id = 2;
    } elseif ($prospect->orders->count()) {
      $state_id = 3;
    } elseif($prospect->state_id === 2){
      $state_id = 2;
    }
    $prospect->update(['state_id' => $state_id]);
    $custom_state = $data['custom_prospect_state'] ?? null;
    $state = $data['prospect_state'] ?? null;
    static::setCustomProspectState($state, $custom_state, $prospect);
    static::createStateTransitionObject($prospect);
    return $prospect;
  }
  
  static function setCustomProspectState($state, $custom_state, $prospect)
  {
    if ($state) {
      if ($state != 'custom') {
        $state_id = static::getOrCreateCustomStateId($state);
      } elseif ($custom_state) {
        $state_id = static::getOrCreateCustomStateId($custom_state);
      } else {
        return;
      }
      $prospect->update(['state_id' => $state_id]);
    }
  }

  static function getOrCreateCustomStateId($state)
  {
    $custom_state = ProspectState::where('title', $state)->first();

    if (!$custom_state) {
      $custom_state = ProspectState::create(['title' => $state]);
      return $custom_state->id;
    }

    return $custom_state->id;
  }

  static function getCustomStateTitle($id)
  {
    $state = ProspectState::find($id);
    if ($state) {
      return $state->title;
    } else {
      return 'undefined';
    }
  }

  static function storeProspectContact($id, $data)
  {
    $prospect = static::findProspect($id);
    $data = $data->all();
    $data = $data->all();
    if ($data['custom_state']) {
      $state_id = static::getOrCreateCustomStateId($data['custom_state']);
      unset($data['custom_state']);
      $prospect->update(['state_id' => $state_id]);
    } else {
      unset($data['custom_state']);
      $prospect->update(['state_id' => 2]);
    }
    $prospect->update($data);
    $prospect->update(['state_id'=>2]);
    return $prospect;
  }
  static function findProspect($id)
  {
    $prospect = Prospect::find($id);
    if (!$prospect) {
      abort(404);
    }
    return $prospect;
  }
  static function createStateTransitionObject($prospect)
 {
    $prospect_state_transition = ProspectStateTransitionTracking::create([
      'prospect_id' => $prospect->id,
      'state_id' => $prospect->state_id
    ]);
  }
}
