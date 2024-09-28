<?php

namespace App\Models;

use App\Contracts\BookingInterface;

class Booking implements BookingInterface
{
    protected $bookingDetails;

    public function __construct(array $bookingDetails)
    {
        $this->bookingDetails = $bookingDetails;
    }

    public function getBookingDetails(): array
    {
        return $this->bookingDetails;
    }
}