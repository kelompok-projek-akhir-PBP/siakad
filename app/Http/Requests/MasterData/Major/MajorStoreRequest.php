<?php

namespace App\Http\Requests\MasterData\Major;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MajorStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:majors,name',
            'abbrevation' => 'required|string|max:255|unique:majors,abbrevation',
            'is_active_checkbox' => 'nullable'
        ];
    }
}
