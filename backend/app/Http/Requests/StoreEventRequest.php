<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'category_id' => 'required|exists:event_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'starts_at' => 'required|date|after:now',
            'ends_at' => 'required|date|after:starts_at',
            'is_volunteer_event' => 'sometimes|boolean',
            'volunteer_points' => 'nullable|integer|min:1',
            'max_participants' => 'nullable|integer|min:1'
        ];
    }

    public function messages(): array
    {
        return [
            'title' => 'Il titolo è obbligatorio',
            'description' => 'La descrizione è obbligatoria',
            'category_id' => 'La categoria è obbligatoria',
            'starts_at' => 'Inserire una data valida',
            'ends_at' => 'Inserire una data valida',
        ];
    }
}
