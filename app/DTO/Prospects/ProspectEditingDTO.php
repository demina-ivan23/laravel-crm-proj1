<?php
namespace App\DTO\Prospects;

// use App\DTO\Prospects\ProspectsCreationDTO;

class ProspectEditingDTO extends ProspectСreationDTO
{
    public int $id;
    public function __construct( 
    int $id,
    string $name,
    string $email,
    ?string $phone_number = null,
    ?string $facebook_account = null,
    ?string $instagram_account = null,
    ?string $address = null,
    ?string $personal_info = null,
    ?int $state_id = null,) 
    {
        parent::__construct(
         $name,
         $email,
         $phone_number,
         $facebook_account,
         $instagram_account,
         $address,
         $personal_info,
         $state_id);
        $this->id = $id;
    }
}