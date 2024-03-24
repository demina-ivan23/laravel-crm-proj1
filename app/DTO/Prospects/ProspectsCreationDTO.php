<?php
namespace App\DTO\Prospects;

class ProspectsСreationDTO
{
    public string $name;
    public string $email;
    public string $profile_image;
    public string $phone_number;
    public string $facebook_account;
    public string $instagram_account;
    public string $address;
    public string $personal_info;
    public int $state_id;
    public function __construct(
        string $name,
        string $email,
        ?string $profile_image,
        ?string $phone_number,
        ?string $facebook_account,
        ?string $instagram_account,
        ?string $address,
        ?string $personal_info,
        ?int $state_id,
    ) {
        $this->$name = $name;
        $this->$email = $email;
        $this->$profile_image = $profile_image;
        $this->$phone_number = $phone_number;
        $this->$facebook_account = $facebook_account;
        $this->$instagram_account = $instagram_account;
        $this->$address = $address;
        $this->$personal_info = $personal_info;
        $this->$state_id = $state_id;
    }
}