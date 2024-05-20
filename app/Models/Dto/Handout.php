<?php

namespace App\Models\Dto;

use App\Models\Clients;
use Carbon\Carbon;

class Handout
{
    public function __construct(
        public ?Clients $client,
        public ?Carbon $startDate,
        public ?Carbon $endDate,
        public ?string $customName,
        public ?string $customDateLabel,
    ) {
    }

    public function hasPeriod(): bool
    {
        return $this->endDate !== null;
    }

    public function hasCustomName(): bool
    {
        return $this->customName !== null;
    }

    public function hasCustomDateLabel(): bool
    {
        return $this->customDateLabel !== null;
    }
}
