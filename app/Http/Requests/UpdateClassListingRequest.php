<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'starts_at' => ['required', 'date'],
            'location' => ['nullable', 'string', 'max:200'],
            'capacity' => ['nullable', 'integer', 'min:1', 'max:100000'],
            'sold_out' => ['nullable', 'boolean'],
            'description' => ['nullable', 'string'],
            'flyer' => ['nullable', 'image', 'max:5120'],
            'remove_flyer' => ['nullable', 'boolean'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:1000000'],
            'deposit' => ['nullable', 'numeric', 'min:0', 'max:1000000'],
            'charity_link' => ['nullable', 'url', 'max:500'],
        ];
    }
}
