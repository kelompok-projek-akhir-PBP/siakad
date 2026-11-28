<?php

namespace App\Http\Requests\MasterData\Subject;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubjectStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:subjects,name',
            'kkm' => 'required|integer',
            'weight_activity' => 'required|integer',
            'weight_lesson' => 'required|integer',
            'is_active_checkbox' => 'nullable'
        ];
    }
}
