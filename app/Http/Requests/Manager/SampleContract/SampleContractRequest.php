<?php

namespace App\Http\Requests\Manager\SampleContract;

use App\DTO\Manager\SampleContract\SampleContractDto;
use App\Models\ProviderDetail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SampleContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'nullable',
            'template_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contract_type' => 'required|in:individual,company',
            'status' => 'required|in:draft,active,archived',
            'version' => 'required|string|max:20',
            'is_default' => 'nullable|boolean',
            'sections' => 'nullable|array',
            'notes' => 'nullable|string',
            'metadata' => 'nullable|array',
            'signature_image' => 'nullable|file',
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'detail_id' => ProviderDetail::first()?->id,
            'sections' => $this->input('sections', []),
            'metadata' => $this->input('metadata', [])
        ]);
    }

    public function getDto(): SampleContractDto
    {
        return SampleContractDto::fromArray($this->validated());
    }
}
