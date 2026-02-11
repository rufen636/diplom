<?php

namespace App\DTO\Manager;

use Illuminate\Contracts\Validation\ValidatesWhenResolved;
use Illuminate\Validation\ValidatesWhenResolvedTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

abstract class AbstractDto implements ValidatesWhenResolved
{
    use ValidatesWhenResolvedTrait;

    abstract public function rules(): array;

    public function messages(): array
    {
        return [];
    }

    public function attributes(): array
    {
        return [];
    }

    public function validateResolved()
    {
        $validator = Validator::make(
            $this->getData(),
            $this->rules(),
            $this->messages(),
            $this->attributes()
        );

        $validator->validate();

        $this->fillValidatedData($validator->validated());
    }

    protected function getData()
    {
        return request()->all();
    }

    protected function fillValidatedData(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}
