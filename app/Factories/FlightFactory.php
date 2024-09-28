<?php
namespace App\Factories;

use App\Contracts\FlightInterface;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Collection;

class FlightFactory implements FlightInterface
{
    public static function create(array $details): FlightInterface
    {
        return new Flight($details);
    }

    public function getAllFlights(): Collection
    {
        return Flight::all();
    }

    public function getFlightById(int $id): ?Flight
    {
        return Flight::find($id);
    }
}
