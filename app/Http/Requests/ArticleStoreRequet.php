<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequet extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'article_description' => ['required', 'string', 'min:10', 'max:5000'],
            'comic_number' => ['required', 'integer', 'min:1'],
            'comic_year' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:6144'],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*' => ['integer', 'distinct', 'exists:categories,id'],
            'rivista_id' => ['nullable', 'integer', 'exists:riviste,id'],
        ];
    }
}
