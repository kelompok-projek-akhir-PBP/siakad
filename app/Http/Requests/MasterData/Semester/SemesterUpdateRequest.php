<?php

namespace App\Http\Requests\MasterData\Semester;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SemesterUpdateRequest extends FormRequest
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
            'academic_year_id' => 'required|integer|exists:academic_years,id',
            'type' => 'required|string|in:ganjil,genap',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_active_checkbox' => 'nullable'
        ];
    }
}
