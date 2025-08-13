<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255',
                       Rule::unique(User::class)->ignore($this->user()->id)],
            'student_id' => ['nullable', 'string', 'max:50'],
            'graduation_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 5)],
            'program' => ['nullable', 'string', 'max:100'],
        ];
    }
}
