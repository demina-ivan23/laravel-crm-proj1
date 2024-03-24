<?php
namespace App\DTO\Prospects;

use App\DTO\Prospects\ProspectsCreationDTO;

class ProspectEditingReadingDTO extends ProspectsCreationDTO
{
    public int $id;
    public function __construct( 
    int $id,
    string $name,
    string $email,
    ?string $profile_image,
    ?string $phone_number,
    ?string $facebook_account,
    ?string $instagram_account,
    ?string $address,
    ?string $personal_info,
    ?int $state_id,) 
    {
        parent::__construct(
         $name,
         $email,
         $profile_image,
         $phone_number,
         $facebook_account,
         $instagram_account,
         $address,
         $personal_info,
         $state_id);
        $this->$id = $id;
    }
}