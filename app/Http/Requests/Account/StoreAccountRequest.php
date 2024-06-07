<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_id' => 'required|numeric|exists:users,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'town_city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'post_code' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
        ];
    }
}
