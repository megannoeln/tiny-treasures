<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArtworkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', 'string', 'max:220'],
            'description' => ['nullable', 'string'],
            'year' => ['nullable', 'integer', 'min:0', 'max:3000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'is_for_sale' => ['nullable', 'boolean'],
            'is_sold' => ['nullable', 'boolean'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:1000000'],
            'image' => ['nullable', 'image', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }
}
