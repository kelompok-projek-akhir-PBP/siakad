<?php

namespace App\Http\Requests\MasterData\Major;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MajorUpdateRequest extends FormRequest
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
        $major_id = $this->route('major');
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('major', 'name')->ignore($major_id)],
            'abbrevation' => ['required', 'string', 'max:255', Rule::unique('major', 'abbrevation')->ignore($major_id)],
            'is_active_checkbox' => 'nullable'
        ];
    }
}
