<?php

namespace App\Http\Requests\User;

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
        $userId = $this->id;
        return [
            'id'=>'required',
            'firstName'=>'required',
            'lastName'=>'required',
            'username'=>'required',Rule::unique('user')->ignore($userId),
            'email'=>'required',Rule::unique('user')->ignore($userId),
            'password'=>'nullable',
            'file'=>  'nullable|image|mimes:jpeg,jpg,png,gif',
            'is_admin' => 'nullable'

        ];
    }
}
