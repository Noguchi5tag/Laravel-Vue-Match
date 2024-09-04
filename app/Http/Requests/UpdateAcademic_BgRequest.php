<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademic_BgRequest extends FormRequest
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
            'school_classification' => 'nullable|string|max:255',
            'school_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'matriculation' => 'nullable|date',
            'graduation' => 'nullable|date',
            'undergraduate' => 'nullable|boolean',
        ];
    }
}
