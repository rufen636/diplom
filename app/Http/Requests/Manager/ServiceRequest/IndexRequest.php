<?php

namespace App\Http\Requests\Manager\ServiceRequest;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'search' => 'nullable|string',
            'status' => 'nullable|string',
        ];
    }
    protected function passedValidation()
    {
        return $this->merge([
            ...$this->validated(),
            'per_page' => $this->per_page ?? 10,
            'page' => $this->page ?? 1,
        ]);
    }
}
