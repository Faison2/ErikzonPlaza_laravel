<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'max:255', 'unique:sub_categories,name,' . $this->route('id')],
            'status' => ['required', 'boolean'],
            'show_at_home' => ['required', 'boolean'],
        ];
    }
}
