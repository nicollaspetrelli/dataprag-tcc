<?php

namespace App\Http\Requests;

use App\Models\Clients;
use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    public const CREATE_CUSTOMER_RULES = [
        'documentNumber' => 'required|max:14',
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

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return self::CREATE_CUSTOMER_RULES;
    }

    public function getDTO(): Clients
    {
        $type = Clients::INDIVIDUAL;

        if ($this->has('documentNumber')) {
            $documentNumber = $this->get('documentNumber');

            if (strlen($documentNumber) === 14) {
                $type = Clients::LEGAL;
                $documentNumber = preg_replace('/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/', '$1.$2.$3/$4-$5', $documentNumber);
            }

            $documentNumber = preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $documentNumber);
        }

        if ($this->has('zipCode')) {
            $zipCode = $this->get('zipCode');
            $zipCode = preg_replace('/^(\d{5})(\d{3})$/', '$1-$2', $zipCode);
        }

        return Clients::create([
            'documentNumber' => $documentNumber,
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
            'type' => $type,
        ]);
    }

    public function normalize(?string $value)
    {
        return ucwords(mb_strtolower($value));
    }
}
