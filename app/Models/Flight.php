<?php

namespace App\Models;

use App\Contracts\FlightInterface;

class Flight implements FlightInterface
{
    protected $details;

    public function __construct(array $details)
    {
        $this->details = $details;
    }

    public function getDetails(): array
    {
        return $this->details;
    }
}