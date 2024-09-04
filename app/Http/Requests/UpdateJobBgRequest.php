<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobBgRequest extends FormRequest
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
            'job_title' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'start_enrollment' => 'nullable|date',
            'end_enrollment' => 'nullable|date',
            'currently_working' => 'nullable|boolean',
        ];
    }
}
