<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            // il valore è unique ma ignora però il titolo che stiamo modificando
            'title' => ['required', 'max:255', 'min:2', Rule::unique('projects')->ignore($this->project)],//Lo prende grazie al dipendcy injection
            'description' => ['nullable', 'min:5', 'max:6000'],
            'technologies' => ['nullable', 'exists:technologies,id']
        ];
    }
}