<?php

namespace App\Http\Requests\AuroraStore;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "name" => [
                "required",
                "string",
                $this->route()->store
                    ? "unique:stores,name," . $this->route()->store
                    : "unique:stores,name",
            ],
            "location" => [
                "required",
                "string",
                $this->route()->store
                    ? "unique:stores,location," . $this->route()->store
                    : "unique:stores,location",
            ],
        ];
    }
}
