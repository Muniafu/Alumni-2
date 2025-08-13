<?php

namespace App\Http\Requests\JobPosting;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobPostingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return auth()->user()->hasAnyRole(['admin', 'alumni']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company'=>'nullable|string|max:255',
            'location'=>'nullable|string|max:255',
            'type'=>'nullable|in:full-time,part-time,internship,contract',
            'deadline'=>'nullable|date|after:today',
            'is_active'=>'boolean',
        ];
    }
}
