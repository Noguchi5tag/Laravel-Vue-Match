<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'kana' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'tel' => ['required', 'string'],
            'sex' => ['required', 'integer', 'in:0,1,2'],
            'birth' => ['required', 'date'],
            'postal' => ['required', 'integer'],
            'prefectures' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
            'privacy' => ['nullable', 'boolean'],
            'profile_image' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
