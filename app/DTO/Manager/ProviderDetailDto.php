<?php

namespace App\DTO\Manager;

use App\DTO\Manager\AbstractDto;
use App\DTO\Manager\DtoInterface;
use Illuminate\Support\Arr;

final class ProviderDetailDto  implements DtoInterface
{
    public $id;
    public string $full_name;
    public string $legal_address;
    public string $actual_address;
    public string $phone;
    public string $email;
    public string $bank_details;
    public string $website;

    /**
     * @param string $full_name
     * @param string $legal_address
     * @param string $actual_address
     * @param string $phone
     * @param string $email
     * @param string $bank_details
     * @param string $website
     */
    public function __construct($id ,string $full_name, string $legal_address, string $actual_address, string $phone, string $email, string $bank_details, string $website)
    {
        $this->id = $id;
        $this->full_name = $full_name;
        $this->legal_address = $legal_address;
        $this->actual_address = $actual_address;
        $this->phone = $phone;
        $this->email = $email;
        $this->bank_details = $bank_details;
        $this->website = $website;
    }


    public static function fromArray(array $data): self
    {
        $id = Arr::get($data, 'id') ?? null;

        $object = new self(
            $id,
        Arr::get($data, 'full_name',[]),
        Arr::get($data, 'legal_address',[]),
        Arr::get($data, 'actual_address',[]),
        Arr::get($data, 'phone',[]),
        Arr::get($data, 'email',[]),
        Arr::get($data, 'bank_details',[]),
        Arr::get($data, 'website',[]),
        );
        return $object;
    }

}
