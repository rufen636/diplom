<?php

namespace App\Http\Requests\Manager;

use App\DTO\Manager\ProviderDetailDto;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailsRequest extends FormRequest
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
            'full_name' => 'required|string',
            'legal_address' => 'required|string',
            'actual_address' => 'nullable|string',
            'phone' => 'required|string',
            'email' => 'nullable|string',
            'bank_details' => 'nullable|string',
            'website' => 'nullable|string',
        ];
    }
    public function getDto(): ProviderDetailDto
    {
        return  ProviderDetailDto::fromArray($this->validationData());
    }
}
