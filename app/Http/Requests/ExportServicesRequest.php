<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportServicesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'services' => 'required|array',
            'payments' => 'required|boolean',
            'output' => 'required|string|in:pdf,docx',
        ];
    }

    public function hasToPrintPayment(): bool
    {
        $hasToPrintPayment = $this->get('payments') ?? 0;

        return (bool) $hasToPrintPayment;
    }
}
