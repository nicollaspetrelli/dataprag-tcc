<?php

namespace App\Http\Requests;

use App\Models\Clients;
use App\Models\Dto\ServiceDataToCreate;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $request = $this->all();
        $services = $request['services'];

        $rules = [
            'customer' => 'required|int|exists:clients,id',
            'services' => 'required|array',
            'services.*.date.0.startDate' => 'required|string',
            'services.*.date.0.endDate' => 'required|string',
            'services.*.value' => 'required|numeric',
            'services.*.description' => 'string|nullable|max:190',
        ];

        if (isset($services['dc'])) {
            $rules = array_merge($rules, $this->validateDC());
        }

        return $rules;
    }

    private function validateDC(): array
    {
        return [
            'services.dc.details' => 'required|array',
        ];
    }

    public function getDTO(): ServiceDataToCreate
    {
        return new ServiceDataToCreate(
            $this->getClient(),
            $this->getServices()
        );
    }

    private function getClient()
    {
        return Clients::findOrFail($this->input('customer'));
    }

    private function getServices(): array
    {
        return $this->input('services');
    }
}
