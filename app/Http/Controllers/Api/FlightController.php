<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\AirportList;
use App\Models\Airport;
use Illuminate\Http\Request;
use App\Constants\Constants;
use App\Http\Services\SearchFlightService;
use App\Models\Setting\GeneralSetting;
use App\ThirdParty\AirIqService;
use App\ThirdParty\GoFlySmartService;
use App\User;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

use Symfony\Component\Routing\Annotation\Route;

class FlightController extends Controller
{
    public function __construct(protected SearchFlightService $SearchFlightService, protected AirIqService $AirIqService, protected GoFlySmartService $GoFlySmartService)
    {

    }

 /**
 * @OA\Get(
 *     path="/swadesitravel/webview/public/api/airport-list",
 *     tags={"Flights"},
 *     summary="Get All Airports",
 *     description="Get all Airports by this API",
 *     operationId="airportList",
 *     @OA\Parameter(
 *         name="status",
 *         in="query",
 *         description="Status values that needed to be considered for filter",
 *         required=true,
 *         @OA\Schema(
 *             type="string",
 *             enum={"available", "pending", "sold"},
 *             default="available"
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Invalid status value"
 *     )
 * )
 */


    public function airportList()
    {
        try {
            $cacheTTL = Constants::AIRPORT_CACHE_TIME;
            $cacheKey = Constants::AIRPORT_CACHE_KEY;
            $airports = Cache::get($cacheKey);
            if (empty($airports)) {
                $airports = Airport::select('name', 'municipality', 'iata_code')->orderBy('name')->get();
                if (!$airports->isEmpty()) {
                    Cache::put($cacheKey, $airports, $cacheTTL);
                } else {
                    return response()->json([
                        'code' => Constants::BAD_REQUEST,
                        'status' => Constants::ACTIVE_STATUS,
                        'message' => __('message.data_not_found'),
                    ]);
                }
            }
            return response()->json([
                'code' => Constants::SUCCESS_REQUEST,
                'status' => Constants::ACTIVE_STATUS,
                'message' => __('message.airport_list'),
                'data' => $airports,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => Constants::BAD_REQUEST,
                'status' => Constants::DEACTIVE_STATUS,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
 * @OA\Post(
 *     path="/swadesitravel/webview/public/api/availability",
 *     tags={"Flights"},
 *     summary="Search availability for flights",
 *     description="This API is for searching flights according to the origin and destination",
 *     operationId="availability",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="origin", type="string", example="AMD", description="Origin airport code"),
 *             @OA\Property(property="destination", type="string", example="BLR", description="Destination airport code")
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="successful operation"
 *     )
 * )
 */
    public function availability(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin'            => 'string|required',
            'destination'       => 'string|required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => Constants::BAD_REQUEST,
                'status' => Constants::DEACTIVE_STATUS,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            //$this->AirIqService->searchFlight($request->all());
            $flights = $this->GoFlySmartService->availability($request->all());
            if (!empty($flights)) {
                return response()->json([
                    'code' => Constants::SUCCESS_REQUEST,
                    'status' => Constants::ACTIVE_STATUS,
                    'message' => __('message.flight_list'),
                    'data' =>  $flights
                ]);
            } else {
                return response()->json([
                    'code' => Constants::BAD_REQUEST,
                    'status' => 1,
                    'message' => __('message.data_not_found'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 401,
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }
/**
 * @OA\Post(
 *     path="/swadesitravel/webview/public/api/search-flight",
 *     tags={"Flights"},
 *     summary="Search Flights",
 *     description="This API is for searching flights according to the origin and destination",
 *     operationId="searchFlight",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="origin", type="string", example="AMD", description="Origin airport code"),
 *             @OA\Property(property="destination", type="string", example="BLR", description="Destination airport code"),
 *             @OA\Property(property="departure_date", type="string", format="date", example="2024/08/20", description="Departure date in YYYY/MM/DD format"),
 *             @OA\Property(property="adult", type="integer", example=1, description="Number of adult passengers"),
 *             @OA\Property(property="child", type="integer", example=1, description="Number of child passengers"),
 *             @OA\Property(property="infant", type="integer", example=0, description="Number of infant passengers")
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="successful operation"
 *     )
 * )
 */

    public function searchFlight(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'origin'            => 'string|required',
            'destination'       => 'string|required',
            'departure_date'    => 'date|required',
            'adult'             => 'integer|required',
            'child'             => 'integer|required',
            'infant'            => 'integer|required',
        ]);
        $searchKey = $request->all();
        $finalArr = Constants::BLANK_ARRAY;
        if ($validator->fails()) {
            return response()->json([
                'code' => Constants::BAD_REQUEST,
                'status' => Constants::DEACTIVE_STATUS,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $settings = $this->getSetting();
            $vendorServices = $this->SearchFlightService->searchFlights($searchKey);
            $flights = [];
            foreach ($vendorServices as $service) {
                $flights[] = $this->$service->searchFlight($searchKey,$service);
            }
            foreach($flights as $flight){
                if(!empty($flight)){
                    $finalArr = $flight;
                }
            }
            if (!empty($finalArr)) {
                return response()->json([
                    'code' => Constants::SUCCESS_REQUEST,
                    'status' => Constants::ACTIVE_STATUS,
                    'message' => __('message.flight_list'),
                    'charges' =>  $settings,
                    'data' =>  $finalArr
                ]);
            } else {
                return response()->json([
                    'code' => Constants::BAD_REQUEST,
                    'status' => Constants::DEACTIVE_STATUS,
                    'message' => __('message.data_not_found'),
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => Constants::BAD_REQUEST,
                'status' => Constants::DEACTIVE_STATUS,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function getSetting(){
        $data = GeneralSetting::select('service_charge','gst_applied')->first();
        return $data;
    }
}
