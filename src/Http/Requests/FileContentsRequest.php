<?php

namespace Facade\CodeEditor\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileContentsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required',
        ];
    }
}
