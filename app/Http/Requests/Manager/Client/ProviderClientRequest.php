<?php

namespace App\Http\Requests\Manager\Client;

use App\DTO\Manager\ProviderClient\ClientDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProviderClientRequest extends FormRequest
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
            'id' => 'nullable|integer|exists:provider_clients,id',
            'name' => 'required|string',
            'contact_person' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'type' => 'required|string',
            'address' => 'nullable|string',
            'client_details.*' => 'nullable|array',
            'client_details.full_name'=> 'nullable|string',
            'client_details.legal_address'=> 'nullable|string',
            'client_details.inn'=> 'nullable|string',
            'client_details.kpp'=> 'nullable|string',
            'client_details.actual_address'=> 'nullable|string',
            'client_details.phone'=> 'nullable|string',
            'client_details.email'=> 'nullable|string',
            'client_details.bank_details'=> 'nullable|string',
            'client_details.doc_type'=> 'nullable|string',
            'client_details.identity_number'=> 'nullable|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ];
    }
    public function passedValidation()
    {
        $client = $this->validated();

        return $this->merge([
            ...$client,
            'user_id' => Auth::user()->id ?? 1,
        ]);
    }
    public function getDto(): ClientDto
    {
        return  ClientDto::fromArray($this->validationData());
    }
}
