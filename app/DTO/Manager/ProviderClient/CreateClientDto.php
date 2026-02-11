<?php

namespace App\DTO\Manager\ProviderClient;

use App\DTO\Manager\AbstractDto;
use App\DTO\Manager\DtoInterface;
use Illuminate\Support\Arr;

final class CreateClientDto  implements DtoInterface
{
    public  $id;
    public string $name;
    public string $contact_person;
    public string $email;
    public string $phone;
    public string $type;
    public string $address;
    public string $inn;
    public string $kpp;
    public string $status;
    public string $notes;
    public int $user_id;

    /**
     * @param string $name
     * @param string $contact_person
     * @param string $email
     * @param string $phone
     * @param string $type
     * @param string $address
     * @param string $inn
     * @param string $kpp
     * @param string $status
     * @param string $notes
     */
    public function __construct(
        $id = null,
        string $name,
        string $contact_person,
        string $email,
        string $phone,
        string $type,
        string $address,
        string $inn,
        string $kpp,
        string $status,
        string $notes,
        int $user_id
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->contact_person = $contact_person;
        $this->email = $email;
        $this->phone = $phone;
        $this->type = $type;
        $this->address = $address;
        $this->inn = $inn;
        $this->kpp = $kpp;
        $this->status = $status;
        $this->notes = $notes;
        $this->user_id = $user_id;
    }

    public static function fromArray(array $data): self
    {
        $id = Arr::get($data, 'id') ?? null;
        $object = new self(
            $id,
            Arr::get($data, 'name',[]),
            Arr::get($data, 'contact_person',[]),
            Arr::get($data, 'email',[]),
            Arr::get($data, 'phone',[]),
            Arr::get($data, 'type',[]),
            Arr::get($data, 'address',[]),
            Arr::get($data, 'inn',[]),
            Arr::get($data, 'kpp',[]),
            Arr::get($data, 'status',[]),
            Arr::get($data, 'notes',[]),
            Arr::get($data, 'user_id',[])
        );
        return $object;
    }

}
