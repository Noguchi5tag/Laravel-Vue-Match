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
            'company_name' => 'required|string|max:255',
            'company_business' => 'required|string|max:255',
            'start_enrollment_year' => 'required|integer',
            'start_enrollment_month' => 'required|integer',
            'currently_working' => 'required|boolean',
            'end_enrollment_year' => 'nullable|integer',
            'end_enrollment_month' => 'nullable|integer',
            'business_other' => 'nullable|string|max:255',
            'company_post' => 'required|string|max:255',
            'company_pay_type' => 'nullable|string|max:255',
            'company_pay' => 'nullable|integer',
        ];
    }
}
