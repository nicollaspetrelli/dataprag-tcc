<?php

namespace App\Http\Requests;

use App\Models\Clients;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'companyName' => 'required|max:190',
            'fantasyName' => 'required|max:190',
            'identificationName' => 'required|max:190',
            'state' => 'required|max:2',
            'city' => 'required|max:190',
            'zipCode' => 'required|max:10',
            'street' => 'required|max:190',
            'number' => 'required|max:190',
            'neighborhood' => 'required|max:190',
            'complement' => 'max:190',
            'notes' => 'max:190',
        ];
    }

    public function getDTO(): Clients
    {
        $customer = Clients::findOrFail($this->id);

        if ($this->has('zipCode')) {
            $zipCode = $this->get('zipCode');
            $zipCode = preg_replace('/^(\d{5})(\d{3})$/', '$1-$2', $zipCode);
        }

        $customer->update([
            'companyName' => $this->normalize($this->companyName),
            'fantasyName' => $this->normalize($this->fantasyName),
            'identificationName' => $this->normalize($this->identificationName),
            'state' => mb_strtoupper($this->state),
            'city' => $this->normalize($this->city),
            'zipcode' => $zipCode,
            'street' => $this->normalize($this->street),
            'number' => $this->normalize($this->number),
            'neighborhood' => $this->normalize($this->neighborhood),
            'complement' => $this->normalize($this->complement),
            'notes' => $this->notes,
        ]);


        return $customer;
    }

    public function normalize(?string $value)
    {
        return ucwords(mb_strtolower($value));
    }
}
