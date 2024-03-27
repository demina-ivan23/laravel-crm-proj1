<?php
namespace App\DTO\Prospects;

class ProspectsСreationDTO
{
    public string $name;
    public string $email;
    public ?string $phone_number;
    public ?string $facebook_account;
    public ?string $instagram_account;
    public ?string $address;
    public ?string $personal_info;
    public ?int $state_id;
    public function __construct(
        string $name,
        string $email,
        ?string $phone_number = null,
        ?string $facebook_account = null,
        ?string $instagram_account = null,
        ?string $address = null,
        ?string $personal_info = null,
        ?int $state_id = null,
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->facebook_account = $facebook_account;
        $this->instagram_account = $instagram_account;
        $this->address = $address;
        $this->personal_info = $personal_info;
        $this->state_id = $state_id;
    }
}