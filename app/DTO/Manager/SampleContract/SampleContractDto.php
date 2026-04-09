<?php

namespace App\DTO\Manager\SampleContract;

use App\DTO\Manager\DtoInterface;
use Illuminate\Support\Arr;

final class SampleContractDto implements DtoInterface
{
    public ?int $id;
    public string $template_code;
    public string $name;
    public ?string $description;
    public string $contract_type;
    public string $status;
    public string $version;
    public bool $is_default;
    public array $sections;
    public array $metadata;
    public ?string $notes;
    public ?int $detail_id;
    public  $signature_image;
    public function __construct(
        ?int $id,
        string $template_code,
        string $name,
        ?string $description,
        string $contract_type,
        string $status,
        string $version,
        bool $is_default,
        array $sections,
        array $metadata,
        ?string $notes,
        ?int $detail_id,
        $signature_image
    ) {
        $this->id = $id;
        $this->template_code = $template_code;
        $this->name = $name;
        $this->description = $description;
        $this->contract_type = $contract_type;
        $this->status = $status;
        $this->version = $version;
        $this->is_default = $is_default;
        $this->sections = $sections;
        $this->metadata = $metadata;
        $this->notes = $notes;
        $this->detail_id = $detail_id;
        $this->signature_image = $signature_image;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            Arr::get($data, 'id'),
            Arr::get($data, 'template_code', ''),
            Arr::get($data, 'name', ''),
            Arr::get($data, 'description'),
            Arr::get($data, 'contract_type', 'individual'),
            Arr::get($data, 'status', 'draft'),
            Arr::get($data, 'version', '1.0'),
            (bool) Arr::get($data, 'is_default', false),
            (array) Arr::get($data, 'sections', []),
            (array) Arr::get($data, 'metadata', []),
            Arr::get($data, 'notes'),
            Arr::get($data, 'detail_id'),
            Arr::get($data, 'signature_image',[])
        );
    }
}
