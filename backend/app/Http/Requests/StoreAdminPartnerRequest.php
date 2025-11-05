<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminPartnerRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'is_active' => 'boolean',
        ];

        if ($this->boolean('addBusiness')) {
            $rules = array_merge($rules, [
                'business_name' => 'required|string|max:255',
                'business_category_id' => 'nullable|exists:business_categories,id',
                'business_address' => 'required|string',
                'business_description' => 'nullable|string',
                'contact_phone' => 'nullable|string|max:20',
                'business_email' => 'nullable|email',
            ]);
        }

        return $rules;
    }


    public function messages(): array
    {
        return [
            'business_name.required' => 'Il nome dell’attività è obbligatorio.',
            'business_category_id.required' => 'Seleziona una categoria per l’attività.',
            'business_address.required' => 'L’indirizzo dell’attività è obbligatorio.',
        ];
    }
}
