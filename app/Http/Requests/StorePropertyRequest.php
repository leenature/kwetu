<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required|unique:properties,code',
            'name' => 'required|max:255',
            'type' => 'required',
            'county' => 'required',
            'town' => 'required',
            'address' => 'required',
            'description' => 'nullable',
            'floors' => 'required|integer|min:1',
            'status' => 'required|in:Active,Inactive',
        ];
    }
}