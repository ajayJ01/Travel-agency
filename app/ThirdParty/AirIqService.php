<?php

namespace App\ThirdParty;

use App\Constants\Constants;

class AirIqService implements ThirdPartyFlightServiceInterface
{
    public $baseUrl = 'https://omairiq.azurewebsites.net/';
    public function login()
    {
        $url    = $this->baseUrl.'login';
        $body   = array('Username'=>'9555202202','Password'=>'9800830000@testapi');
        $header = array(
                        'api-key: NTMzNDUwMDpBSVJJUSBURVNUIEFQSToxODkxOTMwMDM1OTk2OlFRYjhLVjNFMW9UV05RY1NWL0Vtcm9UYXFKTSs5dkZvaHo0RzM4WWhwTDhsamNqR3pPN1dJSHhVQ2pCSzNRcW0=',
                        'Content-Type: application/json',
                    );
        $response = $this->curlData($url, $body, $header, 'POST');
        $token = !empty($response)?$response['token']:'';
        return $token;
    }

    public function searchFlight($searchKey)
    {
        $token      = $this->login();
        $url        = $this->baseUrl.'search';
        $body       = $searchKey;
        $header     = array(
                        'api-key: NTMzNDUwMDpBSVJJUSBURVNUIEFQSToxODkxOTMwMDM1OTk2OlFRYjhLVjNFMW9UV05RY1NWL0Vtcm9UYXFKTSs5dkZvaHo0RzM4WWhwTDhsamNqR3pPN1dJSHhVQ2pCSzNRcW0=',
                        'Content-Type: application/json',
                        'Authorization:'.$token
                    );
        $response   = $this->curlData($url, $body, $header, 'POST');
        $finalResponse = Constants::BLANK_ARRAY;
        if(!empty($response) && $response['code'] == 200){
            $finalResponse = array('status'=>'1','data'=>$response);
        }
        return $finalResponse;
    }

    public function bookTicket($booking)
    {
        // Logic to get flight details using Amadeus API
    }

    public function ticketDetail()
    {
        // Logic to get flight details using Amadeus API
    }

    public function availability($searchKey)
    {
        // Logic to get flight details using Amadeus API
    }

    protected function curlData($url, $body, $header, $type){
        $response   = '';
		$type     = !empty($type)?strtoupper($type):'PUT';
		$body       = json_encode($body);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => $header,
        ));
        $responseJson = curl_exec($curl);
        $e = curl_error($curl);
		curl_close($curl);
		if(!empty($responseJson)){
			$response = json_decode($responseJson,true);
		}
		return $response;
    }
}
