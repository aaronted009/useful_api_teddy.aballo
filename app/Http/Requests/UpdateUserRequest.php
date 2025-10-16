<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => ['email', 'required', Rule::unique('users')->ignore($this->user->id)], // on User update, make sure unique rule doesn't prevent owner of email to update their infos, keep their mail as is and be told their own mail has already been recorded
            'password' => 'min:8',
            'name' => 'required'
        ];
    }
}
