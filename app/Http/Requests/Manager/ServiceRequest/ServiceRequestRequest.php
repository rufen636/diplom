<?php

namespace App\Http\Requests\Manager\ServiceRequest;

use App\DTO\Manager\ServiceRequest\ServiceRequestDto;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequestRequest extends FormRequest
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
            'id' => 'nullable|numeric',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'service_id' => 'required|numeric',
            'client_id' => 'required|numeric',
            'sample_contract_id' => 'required|numeric',
            'installation_address' => 'nullable|string',
            'status' => 'required|string',
        ];
    }
    public function getDto(): ServiceRequestDto
    {
        return  ServiceRequestDto::fromArray($this->validationData());
    }
}
