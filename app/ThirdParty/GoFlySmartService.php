<?php

namespace App\ThirdParty;

use App\Constants\Constants;
use App\Models\Vendor\Vendor;

class GoFlySmartService implements ThirdPartyFlightServiceInterface
{
    public $baseUrl = 'https://krn.nexusdmc.com/';
    public $apiKey = 'test_5ae54302b7de1d49f785142f48cfd89c1cf96b645d4294e0';
    public $service = 'GoFlySmartService';

    private function getVendorDetails(){
        $vendor = Vendor::where(['service'=>$this->service])->first();
        $vendorDetails = Constants::BLANK_ARRAY;
        if(!empty($vendor)){
            $vendorDetails['id']                    = $vendor['id'];
            $vendorDetails['name']                  = $vendor['name'];
            $vendorDetails['code']                  = $vendor['code'];
            $vendorDetails['service']               = $vendor['service'];
            $vendorDetails['contact_person']        = $vendor['contact_person'];
            $vendorDetails['email']                 = $vendor['email'];
            $vendorDetails['phone']                 = $vendor['phone'];
            $vendorDetails['doc_url']               = $vendor['doc_url'];
            $vendorDetails['environment']           = $vendor['environment'];
            $vendorDetails['commission']            = $vendor['commission'];
            $vendorDetails['commission_type']       = $vendor['commission_type'];
            if($vendor['environment']=='Sandbox'){
                $vendorDetails['credentials'] = $vendor['sandbox_credentials'];
                $vendorDetails['url'] = $vendor['sandbox_url'];
            }else if($vendor['environment']=='Live'){
                $vendorDetails['credentials'] = $vendor['live_credentials'];
                $vendorDetails['url'] = $vendor['live_url'];
            }
        }
        return $vendorDetails;
    }

    public function login(){}
    public function searchFlight($searchKey)
    {
        $vendor = $this->getVendorDetails();
        $credentials = json_decode($vendor['credentials'], true);
        $apiKey = '';
        foreach ($credentials as $item) {
            if ($item['key'] === 'api_key') {
                $apiKey = $item['value'];
                break;
            }
        }

        $finalResponse  = Constants::BLANK_ARRAY;
        $origin         = $searchKey['origin'];
        $destination    = $searchKey['destination'];
        $departure_date = date('Ymd',strtotime($searchKey['departure_date']));
        $adult          = $searchKey['adult'];
        $child          = $searchKey['child'];
        $infant         = $searchKey['infant'];
        $segment        = $origin.'-'.$destination.'-'.$departure_date.'&pax='.$adult.'-'.$child.'-'.$infant;
        $url            = $vendor['url'].'api/v1/flights/series-search?segment='.$segment;
        $body           = Constants::BLANK_ARRAY;
        $header         = array(
                            'api-key: '.$apiKey,
                            'Cookie: JSESSIONID=877336B32B90710BCC579400EFF18D63; ssid=t1'
                        );
        $response       = $this->curlData($url, $body, $header, 'GET');
        if(!empty($response) && !empty($response['success']) && !empty($response['_data'])){
            $filterdata = $this->searchDataFilter($response['_data']['flights'],$vendor);
            $finalResponse = $filterdata;
        }
        return $finalResponse;
    }

    public function searchDataFilter($response,$vendor){
        $finalArr       = Constants::BLANK_ARRAY;
        foreach($response as $flight){
            $data['vendor_id']          = $vendor['id'];
            $data['vendor_commission']  = $vendor['commission'];
            $data['flight_key']         = $flight['key'];
            $data['seats_available']    = $flight['seats_available'];
            $data['baggage_capacity']   = $flight['checkin_baggage'];
            $data['refundable']         = $flight['non_refundable'];
            $data['currency']           = $flight['currency'];
            $data['adult_price']        = $flight['adult_price'];
            $data['child_price']        = $flight['child_price'];
            $data['infant_price']       = $flight['infant_price'];
            $data['total_price']        = $flight['total_price'];
            $data['segments']           = Constants::BLANK_ARRAY;
            if(!empty($flight['segments'])){
                $finalSegment = Constants::BLANK_ARRAY;
                foreach($flight['segments'] as $segment){
                    $seg['duration'] = $segment['duration'];
                    $seg['legs'] = Constants::BLANK_ARRAY;
                    if(!empty($segment['legs'])){
                        $finalLegs = Constants::BLANK_ARRAY;
                        foreach($segment['legs'] as $legs){
                            $leg['flight_number'] = $legs['flight_number'];
                            $leg['airline'] = $legs['airline'];
                            $leg['origin'] = $legs['origin'];
                            $leg['destination'] = $legs['destination'];
                            $leg['duration'] = $legs['duration'];
                            $leg['arrival_time'] = $legs['arrival_time'];
                            $leg['departure_time'] = $legs['departure_time'];
                            $finalLegs[] = $leg;
                        }
                    }
                    $seg['legs'] = $finalLegs;
                    $finalSegment[] = $seg;
                }
            }
            $data['segments'] = $finalSegment;
            $finalArr[] = $data;
        }
        return $finalArr;
    }
    public function bookTicket($booking)
    {
        $finalResponse  = Constants::BLANK_ARRAY;
        prd($booking->booking_data);
        return $finalResponse;
    }

    public function ticketDetail()
    {
        // Logic to get flight details using Amadeus API
    }

    public function availability($searchKey)
    {
        $finalResponse  = Constants::BLANK_ARRAY;
        $origin         = $searchKey['origin'];
        $destination    = $searchKey['destination'];
        $segment        = 'origin='.$origin.'&destination='.$destination;
        $url            = $this->baseUrl.'api/v1/flights/series-dates?'.$segment;
        $body           = Constants::BLANK_ARRAY;
        $header         = array(
                            'api-key: '.$this->apiKey,
                            'Cookie: JSESSIONID=877336B32B90710BCC579400EFF18D63; ssid=t1'
                        );
        $response = $this->curlData($url, $body, $header, 'GET');
        if(!empty($response) && !empty($response['success']) && !empty($response['_data']['sector']['date'])){
            $finalResponse = array('status'=>'1','data'=>$response);
        }else{
            $finalResponse = array('status'=>'0','data'=>[]);
        }
        return $finalResponse;
    }

    protected function curlData($url, $body, $header, $type){
        $response   = '';
		$type       = !empty($type)?strtoupper($type):'PUT';
		$body       = json_encode($body);
        $curl       = curl_init();
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
