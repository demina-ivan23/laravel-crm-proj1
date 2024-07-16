<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Prospect;
use App\Models\ProspectState;
use Exception;

class ProspectService
{
  static function getAllProspects()
  {
    $data = request()->all();
    if (array_key_exists('prospectsWithTrashed', $data)) {
      if ($data['prospectsWithTrashed'] == true) {
        $prospects = Prospect::withTrashed()->latest()->filter()->paginate(15);
      }
    } elseif (array_key_exists('prospectsOnlyTrashed', $data)) {
      if ($data['prospectsOnlyTrashed'] == true) {
        $prospects = Prospect::onlyTrashed()->latest()->filter()->paginate(15);
      }
    } else {
      $prospects = Prospect::latest()->filter()->paginate(15);
    }
    return $prospects;
  }
  static function getAllStates()
  {
    $states = ProspectState::all();
    return $states;
  }
  static function storeProspect(array $data)
  {
    $prospect = Prospect::create(['name' => $data['name']]);
    static::setProspectState($data['prospect_state'], $data['prospect_state_explanation'] ?? null, $prospect);
    unset($data['prospect_state'], $data['prospect_state_explanation']);
    $prospect->update($data);
    $message = new Message([
      'text' => 'Prospect created. State of a prospect: ' . $prospect->latestState->title
    ]);
    $prospect->messages()->save($message);
    return $prospect;
  }
  static function updateProspect(array $data, Prospect $prospect)
  {
    static::setProspectState($data['prospect_state'], $data['prospect_state_explanation'] ?? null, $prospect);
    unset($data['prospect_state'], $data['prospect_state_explanation']);
    $prospect->update($data);
    $message = new Message([
      'text' => 'Prospect updated. State of a prospect: ' . $prospect->latestState->title
    ]);
    $prospect->messages()->save($message);
    return $prospect;
  }

  static function setProspectState(int $state, ?string $explanation, Prospect $prospect)
  {
    try {
      $state = ProspectState::findOrFail($state);
      if ($prospect->latestState != null && $prospect->latestState->id == $state->id) {
        $prospect->states()->updateExistingPivot($state->id, ['explanation' => $explanation]);
      } else {
        $prospect->states()->attach($state, ['explanation' => $explanation]);
      }
      return true;
    } catch (Exception $e) {
      throw new Exception($e->getMessage());
    }
  }
}
