<?php

namespace App\Http\Requests;

use App\Models\Clients;
use App\Models\Dto\Handout;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class HandoutRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client' => 'integer|required_without_all:customName',
            'customName' => 'string|required_without_all:client',
            'customDateLabel' => 'string|required_without_all:startDate',
            'startDate' => 'date||required_without_all:customDateLabel|dateFormat:Y-m-d H:i:s',
            'endDate' => 'date|dateFormat:Y-m-d H:i:s',
        ];
    }

    public function getDto()
    {
        $client = null;

        if ($this->has('client')) {
            $client = Clients::findOrFail($this->input('client'));
        }

        return new Handout(
            client: $client,
            startDate: $this->input('startDate') ? Carbon::parse($this->input('startDate')) : null,
            endDate: $this->input('endDate') ? Carbon::parse($this->input('endDate')) : null,
            customDateLabel: $this->input('customDateLabel') ?? null,
            customName: $this->input('customName') ?? null
        );
    }
}
