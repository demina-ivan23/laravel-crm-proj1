<?php

namespace App\Services;

use App\Models\CustomerState;
use App\Models\Prospect;

class ProspectService
{
  static function getAllProspects()
  {
    $prospects = Prospect::latest()->filter()->paginate(15);
    return $prospects;
  }
  static function getAllStates()
  {
    $states = CustomerState::all();
    return $states;
  }
  static function storeProspect($data)
  {
    $prospectData = [
      'name' => $data['name'],
      'email' => $data['email'],
      'phone_number' => $data['phone_number'] ?? null ,
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
    $custom_state = $data['custom_state'] ?? null;
      if ($custom_state) {
        $state_id = static::getOrCreateCustomStateId($custom_state);
      } else {
        $state_id = $additionalInfoIsNull ? 1 : 2;
      }
      $prospect->update(['state_id' => $state_id]);
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
      'phone_number' => $data['phone_number'] ?? null ,
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
    $custom_state = $data['custom_state'] ?? null;
    $state_id = 1;
      if ($custom_state !== null) {
        $state_id = static::getOrCreateCustomStateId($custom_state);
      } elseif ($prospect->state_id === 1 && !$additionalInfoIsNull) {
        $state_id = 2;
      } elseif ($prospect->orders->count()) {
        $state_id = 3;
      }
      $prospect->update(['state_id' => $state_id]);
    
    return $prospect;
  }

  static function setStateToLead($id)
  {
    $prospect = static::findProspect($id);
    $state_id = 2;
    if ($prospect->state_id === null || $prospect->state_id === 1) {
      $prospect->update(['state_id' => $state_id]);
    }
    return $prospect;
  }

  static function setStateToCustomer($id)
  {
    $prospect = static::findProspect($id);
    $state_id = 3;
    if ($prospect->state_id === null || $prospect->state_id === 1 || $prospect->state_id === 2) {
      $prospect->update(['state_id' => $state_id]);
    }
    return $prospect;
  }

  static function getOrCreateCustomStateId($state)
  {
    $custom_state = CustomerState::where('title', $state)->first();

    if (!$custom_state) {
      $custom_state = CustomerState::create(['title' => $state]);
      return $custom_state->id;
    }

    return $custom_state->id;
  }

  static function getCustomStateTitle($id)
  {
    $state = CustomerState::find($id);
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
    static::setStateToLead($prospect->id);
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
}
