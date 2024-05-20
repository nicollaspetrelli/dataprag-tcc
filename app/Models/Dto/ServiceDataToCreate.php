<?php

namespace App\Models\Dto;

use App\Models\Clients;

class ServiceDataToCreate
{
    public function __construct(
        public Clients $customer,
        public array $services,
    ) {
    }

}
