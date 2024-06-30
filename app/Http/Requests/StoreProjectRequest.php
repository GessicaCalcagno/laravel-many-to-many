<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
        'title' => ['required', 'max:255', 'min:2', 'unique:projects'],
        'description' => ['nullable', 'min:5', 'max:6000'],
        // technologies è opzionale (può essere nullo), ma se viene fornito, ogni elemento dell'array deve esistere nella colonna id della tabella technologies del database
        'technologies' => ['nullable', 'exists:technologies,id']
        ];
    }
}