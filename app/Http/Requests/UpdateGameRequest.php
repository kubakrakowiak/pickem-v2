<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
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
            'team_home' => ['required', 'string', 'min:1', 'max:255'],
            'team_away' => ['required', 'string', 'min:1', 'max:255'],
            'start_at' => ['nullable', 'date', 'after:now'],
        ];
    }
}
