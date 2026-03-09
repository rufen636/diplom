<?php

namespace App\Http\Requests\Manager\SampleContract;

use App\DTO\Manager\ProviderClient\ClientDto;
use App\DTO\Manager\SampleContract\SampleContractDto;
use App\DTO\Manager\SampleContract\ServiceRequestDto;
use App\Models\ProviderDetail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SampleContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'template_code' => 'required|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'contract_type' => 'required|string',
            'status' => 'required|string',
            'version' => 'required|string',
            'is_default' => 'nullable|boolean',
            'preamble' => 'nullable|string',
            'subject_of_contract' => 'nullable|string',
            'rights' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'liability' => 'nullable|string',
            'force_majeure' => 'nullable|string',
            'dispute_resolution' => 'nullable|string',
            'confidentiality' => 'nullable|string',
            'other_conditions' => 'nullable|string',
            'signatures_block' => 'nullable|string',
            'clauses' => 'nullable|string',
            'signature_image' => 'nullable|file',
            'detail_id' => 'nullable|string',
        ];
    }
    public function passedValidation()
    {
        $client = $this->validated();

        return $this->merge([
            ...$client,
            'detail_id' => ProviderDetail::first()->value('id'),
        ]);
    }
    public function getDto(): SampleContractDto
    {
        return  SampleContractDto::fromArray($this->validationData());
    }
}
