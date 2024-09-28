<?php

namespace App\Factories;

use App\ThirdParty\ThirdPartyFlightServiceInterface;
use App\ThirdParty\AmadeusFlightService;
use App\ThirdParty\SkyscannerFlightService;

class ThirdPartyFlightServiceFactory
{
    protected $service;

    public function __construct(string $serviceName)
    {
        switch ($serviceName) {
            case 'amadeus':
                $this->service = new AmadeusFlightService();
                break;
            case 'amadeus':
                $this->service = new AmadeusFlightService();
                break;

            case 'skyscanner':
                $this->service = new SkyscannerFlightService();
                break;

            default:
                throw new \InvalidArgumentException("Service not supported.");
        }
    }

    public function getService(): ThirdPartyFlightServiceInterface
    {
        return $this->service;
    }
}
