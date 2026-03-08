<?php

namespace App\DTO\Manager\SampleContract;

use App\DTO\Manager\AbstractDto;
use App\DTO\Manager\DtoInterface;
use Illuminate\Support\Arr;

final class SampleContractDto  implements DtoInterface
{
    public $id;
    public string $template_code;
    public string $name;
    public string $description;
    public string $contract_type;
    public string $status;
    public string $version;
    public int $is_default;
    public string $preamble;
    public string $subject_of_contract;
    public string $rights;
    public string $payment_terms;
    public string $liability;
    public string $force_majeure;
    public string $dispute_resolution;
    public string $confidentiality;
    public string $other_conditions;
    public $signatures_block;
    public  $clauses;
    public  $signature_image;
    public int $detail_id;/**
 * @param $id
 * @param string $template_code
 * @param string $name
 * @param string $description
 * @param string $contract_type
 * @param string $status
 * @param string $version
 * @param int $is_default
 * @param string $preamble
 * @param string $subject_of_contract
 * @param string $rights_and_obligations
 * @param string $payment_terms
 * @param int $liability
 * @param array $force_majeure
 * @param string $dispute_resolution
 * @param string $confidentiality
 * @param string $other_conditions
 * @param string $signatures_block
 * @param array $clauses
 * @param int $detail_id
 */public function __construct($id, string $template_code, string $name, string $description, string $contract_type, string $status, string $version, int $is_default, string $preamble, string $subject_of_contract, string $rights, string $payment_terms, string $liability, string $force_majeure, string $dispute_resolution, string $confidentiality, string $other_conditions, string $signatures_block,  $clauses, int $detail_id,  $signature_image)
{
    $this->id = $id;
    $this->template_code = $template_code;
    $this->name = $name;
    $this->description = $description;
    $this->contract_type = $contract_type;
    $this->status = $status;
    $this->version = $version;
    $this->is_default = $is_default;
    $this->preamble = $preamble;
    $this->subject_of_contract = $subject_of_contract;
    $this->rights = $rights;
    $this->payment_terms = $payment_terms;
    $this->liability = $liability;
    $this->force_majeure = $force_majeure;
    $this->dispute_resolution = $dispute_resolution;
    $this->confidentiality = $confidentiality;
    $this->other_conditions = $other_conditions;
    $this->signatures_block = $signatures_block;
    $this->clauses = $clauses;
    $this->detail_id = $detail_id;
    $this->signature_image = $signature_image;
}


    public static function fromArray(array $data): self
    {
        $id = Arr::get($data, 'id') ?? null;

        $object = new self(
            $id,
        Arr::get($data, 'template_code',[]),
        Arr::get($data, 'name',[]),
        Arr::get($data, 'description',[]),
        Arr::get($data, 'contract_type',[]),
        Arr::get($data, 'status',[]),
        Arr::get($data, 'version',[]),
        Arr::get($data, 'is_default',[]),
        Arr::get($data, 'preamble',[]),
        Arr::get($data, 'subject_of_contract',[]),
        Arr::get($data, 'rights',[]),
        Arr::get($data, 'payment_terms',[]),
        Arr::get($data, 'liability',[]),
        Arr::get($data, 'force_majeure',[]),
        Arr::get($data, 'dispute_resolution',[]),
        Arr::get($data, 'confidentiality',[]),
        Arr::get($data, 'other_conditions',[]),
        Arr::get($data, 'signatures_block',[]),
        Arr::get($data, 'clauses',[]),
        Arr::get($data, 'detail_id',[]),
            Arr::get($data, 'signature_image',[])
        );
        return $object;
    }

}
