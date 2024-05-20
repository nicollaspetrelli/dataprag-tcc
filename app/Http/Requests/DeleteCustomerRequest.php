<?php

namespace App\Http\Requests;

use App\Models\Clients;
use Illuminate\Foundation\Http\FormRequest;

class DeleteCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    public function getDTO(): Clients
    {
        return Clients::findOrFail($this->id);
    }
}
