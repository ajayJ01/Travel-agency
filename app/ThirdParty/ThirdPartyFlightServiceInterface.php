<?php

namespace App\ThirdParty;

interface ThirdPartyFlightServiceInterface
{

    public function login();

    public function searchFlight($searchKey);

    public function bookTicket($booking);

    public function ticketDetail();

    public function availability($searchKey);
}
