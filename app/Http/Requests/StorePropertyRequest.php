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
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'description' => 'nullable',
            'floors' => 'required|integer|min:1',
            'status' => 'required|in:Active,Inactive',
            'property_client_id' => ['nullable', 'integer', 'exists:property_clients,id'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => ['string', 'max:100'],
            'service_partner_ids' => ['nullable', 'array'],
            'service_partner_ids.*' => ['integer', 'exists:service_partners,id'],
            'exterior_photos' => ['nullable', 'array', 'max:10'],
            'exterior_photos.*' => ['image', 'max:10240'],
            'interior_photos' => ['nullable', 'array', 'max:15'],
            'interior_photos.*' => ['image', 'max:10240'],
            'location_photos' => ['nullable', 'array', 'max:5'],
            'location_photos.*' => ['image', 'max:10240'],
            'verification_documents' => ['nullable', 'array', 'max:5'],
            'verification_documents.*' => ['file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:10240'],
        ];
    }
}
