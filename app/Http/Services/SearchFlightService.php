<?php


namespace App\Http\Services;

use App\Models\Attribute\Attribute;
use App\Models\Vendor\Vendor;
use App\ThirdParty\AirIqService;
use App\ThirdParty\GoFlySmartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class SearchFlightService extends Service
{
    public function __construct(protected GoFlySmartService $GoFlySmartService, protected AirIqService $AirIqService)
    {
    }

    /**
     * @array $data
     * @return array
     */
    public function searchFlights($searchKey)
    {
        $vendors    = Vendor::where(['status'=>'1'])->get();
        $responses  = [];
        if(!empty($vendors)){
            foreach($vendors as $vendor){
                $responses[] = $vendor->service;
            }
        }
        return $responses;
    }
}
