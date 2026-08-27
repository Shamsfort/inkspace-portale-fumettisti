<?php

namespace App\Http\Requests;

class ArticleUpdateRequest extends ArticleStoreRequet
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['image'][0] = 'nullable';

        return $rules;
    }
}
