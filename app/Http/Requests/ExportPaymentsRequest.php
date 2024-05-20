<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportPaymentsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payments' => 'required|numeric',
            'output' => 'required|string|in:pdf,docx',
        ];
    }
}
