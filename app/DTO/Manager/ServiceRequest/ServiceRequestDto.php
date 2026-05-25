<?php

namespace App\DTO\Manager\ServiceRequest;

use App\DTO\Manager\AbstractDto;
use App\DTO\Manager\DtoInterface;
use Illuminate\Support\Arr;

final class ServiceRequestDto  implements DtoInterface
{
    public $id;
    public string $title;
    public string $description;
    public int $service_id;
    public int $client_id;
    public int $sample_contract_id;
    public string $installation_address;
    public string $status;
    public string $tariff_id;

    /**
     * @param $id
     * @param string $title
     * @param string $description
     * @param int $service_id
     * @param int $client_id
     * @param int $sample_contract_id
     * @param string $installation_address
     * @param string $status
     */
    public function __construct($id, string $title, string $description, int $service_id, int $client_id, int $sample_contract_id, string $installation_address, string $status,int $tariff_id)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->service_id = $service_id;
        $this->client_id = $client_id;
        $this->sample_contract_id = $sample_contract_id;
        $this->installation_address = $installation_address;
        $this->status = $status;
        $this->tariff_id = $tariff_id;
    }


    public static function fromArray(array $data): self
    {
        $id = Arr::get($data, 'id') ?? null;

        $object = new self(
            $id,
            Arr::get($data, 'title'),
            Arr::get($data, 'description'),
            Arr::get($data, 'service_id'),
            Arr::get($data, 'client_id'),
            Arr::get($data, 'sample_contract_id'),
            Arr::get($data, 'installation_address'),
            Arr::get($data, 'status'),
            Arr::get($data,'tariff_id'),
        );
        return $object;
    }

}
