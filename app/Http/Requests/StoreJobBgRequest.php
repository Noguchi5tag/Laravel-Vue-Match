<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreJobBgRequest extends FormRequest
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
            'job_title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'start_enrollment' => 'required|date',
            'end_enrollment' => ['nullable', 'date', 'before_or_equal:' . Carbon::today()->toDateString()],
            'currently_working' => 'required|boolean',
        ];
    }
}
