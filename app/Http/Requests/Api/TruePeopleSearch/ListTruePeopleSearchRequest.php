<?php

namespace App\Http\Requests\Api\TruePeopleSearch;

use Illuminate\Foundation\Http\FormRequest;

class ListTruePeopleSearchRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'city' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'citystatezip' => ['nullable'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->has(['city', 'state'])) {
            $this->merge([
                'citystatezip' => $this->city . ', ' . $this->state,
            ]);
        }
    }
}
