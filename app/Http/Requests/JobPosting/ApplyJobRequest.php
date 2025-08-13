<?php

namespace App\Http\Requests\JobPosting;

use Illuminate\Foundation\Http\FormRequest;

class ApplyJobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return auth()->user()->hasRole('student');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [          
            'resume'=>'required|file|mimes:pdf,doc,docx|max:2048',
            'cover_letter'=>'nullable|string|max:5000',
        ];
    }
}
