<?php

namespace App\Http\Requests\MasterData\AcademicYear;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AcademicYearUpdateRequest extends FormRequest
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
        $academicYearId = $this->route('academic_year');
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('academic_years', 'name')->ignore($academicYearId)],
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_active_checkbox' => 'nullable',
        ];
    }
}
