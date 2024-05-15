<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Prospect;
use App\Models\ProspectState;

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
  static function storeProspect(array $data)
  {
    $prospect = Prospect::create($data);    
    static::setProspectState($data['prospect_state'] ?? null, $data['custom_prospect_state'] ?? null, $prospect);
    $message = new Message([
      'text' => 'Prospect created. State of a prospect: ' . $prospect->state->title
    ]);
    $prospect->messages()->save($message);
    return $prospect;
  }
  static function updateProspect(?array $data, Prospect $prospect)
  {
    $prospect->update($data);
    static::setProspectState($data['prospect_state'] ?? null, $data['custom_prospect_state'] ?? null, $prospect);
    $message = new Message([
      'text' => 'Prospect updated. State of a prospect: ' . $prospect->state->title
    ]);
    $prospect->messages()->save($message);
    return $prospect;
  }
  static function deleteProspect(Prospect $prospect)
  {
    $prospect->delete();
  }
  
  static function setProspectState(?string $state, ?string $customState, Prospect $prospect)
  {
    if ($state) {
      if ($state != ('custom' && null)) {
        $stateId = static::getOrCreateState($state);
      } elseif ($customState) {
        $stateId = static::getOrCreateState($customState);
      } else {
        return;
      }
      $prospect->update(['state_id' => $stateId]);
    }
  }

  static function getOrCreateState(?string $stateTitle)
  {
    $state = ProspectState::where('title', $stateTitle)->first() ?? null;
    if (!$state) {
      $customState = ProspectState::create(['title' => $state]);
      return $customState->id;
    }
    return $state->id;
  }

}
