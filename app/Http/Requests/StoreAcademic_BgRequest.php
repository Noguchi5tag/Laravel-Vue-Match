<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreAcademic_BgRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'school_classification' => 'nullable|string|max:255',
            'school_name' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'matriculation' => 'nullable|date',
            'graduation' => ['nullable', 'date', 'before_or_equal:' . Carbon::today()->toDateString()],
            'undergraduate' => 'nullable|boolean',
        ];
    }
    public function messages()
    {
        return [
            'graduation.before_or_equal' => '卒業日は今日以前の日付を指定してください。',
        ];
    }
}
