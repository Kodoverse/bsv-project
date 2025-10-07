<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;


class UpdateAdminPartnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->user_role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $partnerId = $this->route('partner')->id ?? null;

        return [
            'name' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'partner_email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($partnerId)],
        ];
    }
}
