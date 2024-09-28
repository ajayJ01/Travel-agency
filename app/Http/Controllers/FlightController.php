<?php

namespace App\Http\Controllers;

use App\Factories\FlightFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Factories\ThirdPartyFlightServiceFactory;

class FlightController extends Controller
{
    protected $flightFactory;
    protected $flightService;

    public function __construct(FlightFactory $flightFactory)
    {
        $this->flightFactory = $flightFactory;
        $serviceName = env('FLIGHT_SERVICE', 'amadeus');
        $factory = new ThirdPartyFlightServiceFactory($serviceName);
        $this->flightService = $factory->getService();
    }

    public function index()
    {
        $flights = $this->flightFactory->getAllFlights();
        return response()->json($flights);
    }

    public function show($id)
    {
        $flight = $this->flightFactory->getFlightById($id);
        
        if (!$flight) {
            return response()->json(['message' => 'Flight not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($flight);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string|unique:flights,flight_number',
            'source' => 'required|string',
            'destination' => 'required|string',
            'price' => 'required|numeric',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
        ]);

        $flight = $this->flightFactory->createFlight($validated);
        return response()->json($flight, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $flight = $this->flightFactory->getFlightById($id);
        
        if (!$flight) {
            return response()->json(['message' => 'Flight not found'], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'flight_number' => 'string|unique:flights,flight_number,' . $id,
            'source' => 'string',
            'destination' => 'string',
            'price' => 'numeric',
            'departure_time' => 'date',
            'arrival_time' => 'date|after:departure_time',
        ]);

        $flight->update($validated);
        return response()->json($flight);
    }

    public function destroy($id)
    {
        $flight = $this->flightFactory->getFlightById($id);
        
        if (!$flight) {
            return response()->json(['message' => 'Flight not found'], Response::HTTP_NOT_FOUND);
        }

        $flight->delete();
        return response()->json(['message' => 'Flight deleted successfully']);
    }

    public function search(Request $request)
    {
        $criteria = $request->only(['source', 'destination', 'date']);
        $flights = $this->flightService->searchFlights($criteria);
        return response()->json($flights);
    }

    public function details($flightId)
    {
        $flight = $this->flightService->getFlightDetails($flightId);
        return response()->json($flight);
    }
}
