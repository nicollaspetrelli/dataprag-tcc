<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'paymentDate' => 'required|date|date_format:Y-m-d',
            'paymentMethod' => 'required|in:money,pix,boleto,ted,credit,debit',
            'value' => 'required|numeric',
            'services' => 'required|array',
            'paymentDescription' => 'string|nullable|max:190',
        ];
    }
}
