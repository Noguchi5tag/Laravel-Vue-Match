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
            'name' => [ 'string', 'max:255'],
            'kana' => ['string', 'max:255'],
            'email' => ['string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'tel' => ['string'],
            'sex' => ['integer', 'in:0,1,2'],
            'birth' => ['date'],
            'postal' => ['integer'],
            'prefectures' => ['string', 'max:255'],
            'city' => ['string', 'max:255'],
            'status' => ['boolean'],
            'privacy' => ['boolean'],
            'profile_image' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
