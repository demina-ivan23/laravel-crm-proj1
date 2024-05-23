<?php

namespace App\Services;

use Exception;
use App\Models\ProspectState;

class ProspectStateService
{
    static function storeProspectState($data)
    {
        $prospectState = ProspectState::create($data);
        if (!$prospectState) {
            return 'Prospect state creation failed, something must have gone wrong';
        }
        if ($data['can_transit_into'] ?? null) {
            foreach ($data['can_transit_into'] as $id) {
                $prospectState->states()->attach($id);
            }
        }
        return 'Prospect state created successfully';
    }
    static function updateProspectState($data, $prospectState)
    {
        try {
            $prospectState->update($data);
            foreach (ProspectState::all() as $otherProspectState) {
                $prospectState->states->contains($otherProspectState->id) ? $prospectState->states()->detach($otherProspectState->id) : '';
            }
            if ($data['can_transit_into'] ?? null) {
                foreach ($data['can_transit_into'] as $id) {
                    $prospectState->states()->attach($id);
                }
            }
            return 'Prospect state updated successfully';
        } catch (Exception $e) {
            return 'Something went wrong, Exception message: ' . $e->getMessage();
        }
    }
    static function updateProspectStatesViaTable($data)
    {
        try {
            foreach ($data as $key => $value) {
                $keyStringArray = explode('-', $key);
                if (array_key_exists(1, $keyStringArray)  && $keyStringArray[1] == 'can_transit_into') {
                    $prospectState = ProspectState::findOrFail($keyStringArray[0]);
                    foreach ($prospectState->states as $oldProspectState) {
                        $prospectState->states()->detach($oldProspectState->id);
                    }
                    foreach ($value as $item) {
                        $newProspectState = ProspectState::findOrFail($item);
                        if($newProspectState->id !== $prospectState->id){
                            $prospectState->states()->attach($newProspectState->id);
                        }
                    }
                }
            }
            return 'Prospect states updated successfully';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
