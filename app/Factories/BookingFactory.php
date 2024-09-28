<?php
namespace App\Factories;

use App\Contracts\BookingInterface;
use App\Models\Booking;

class BookingFactory
{
    public static function create(array $bookingDetails): BookingInterface
    {
        return new Booking($bookingDetails);
    }
}