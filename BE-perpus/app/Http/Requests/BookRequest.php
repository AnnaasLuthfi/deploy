<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'title' => 'required',
            'summary' => 'required',
            'stok' => 'required',
            'image' => 'required|mimes:jpg,bmp,png',
            'category_id' => 'required|exists:categories,id'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title harus diisi',
            'summary.required' => 'Summary harus diisi',
            'stok.required' => 'stok harus diisi',
            'image.mimes' => 'Format image jpg,bmp,png',
            'category_id.required' => 'genre_id harus diisi',
        ];
    }
}
