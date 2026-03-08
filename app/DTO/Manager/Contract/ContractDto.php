<?php

namespace App\DTO\Manager\Contract;

use App\DTO\Manager\AbstractDto;
use App\DTO\Manager\DtoInterface;
use Illuminate\Support\Arr;

final class ContractDto  implements DtoInterface
{




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
            Arr::get($data, 'status',[]),
            Arr::get($data, 'notes',[]),
            Arr::get($data, 'user_id',[]),
            Arr::get($data, 'client_details',[
            ])
        );
        return $object;
    }

}
