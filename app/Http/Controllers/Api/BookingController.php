<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\Constants;
use App\Http\Services\SearchFlightService;
use App\Models\Booking\Booking;
use App\Models\Booking\PassengerDetails;
use App\Models\User\User;
use App\Models\Vendor\Vendor;
use App\ThirdParty\AirIqService;
use App\ThirdParty\GoFlySmartService;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class BookingController extends Controller
{
    public function __construct(protected SearchFlightService $SearchFlightService, protected AirIqService $AirIqService, protected GoFlySmartService $GoFlySmartService)
    {

    }
/**
 * @OA\Post(
 *     path="/swadesitravel/webview/public/api/booking",
 *     tags={"Booking"},
 *     summary="Booking for flights",
 *     description="This API is for searching flights according to the origin and destination",
 *     operationId="index",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="vendor_id", type="integer", example="2", description="Vendor ID"),
 *             @OA\Property(
 *                 property="search_key",
 *                 type="object",
 *                 @OA\Property(property="adult", type="integer", example=1, description="Number of adults"),
 *                 @OA\Property(property="infant", type="integer", example=1, description="Number of infants"),
 *                 @OA\Property(property="child", type="integer", example=0, description="Number of children"),
 *                 @OA\Property(property="origin", type="string", example="AMD", description="Origin airport code"),
 *                 @OA\Property(property="destination", type="string", example="BLR", description="Destination airport code"),
 *                 @OA\Property(property="departure_date", type="string", example="2024/08/15", description="Departure date in YYYY/MM/DD format")
 *             ),
 *             @OA\Property(property="flight_keys", type="string", example="9095fb2a9571e5e1", description="Flight key"),
 *             @OA\Property(property="sub_total", type="number", format="float", example=10100, description="Subtotal amount"),
 *             @OA\Property(property="discount", type="string", example="", description="Discount applied"),
 *             @OA\Property(property="gst_no", type="string", example="", description="GST No"),
 *             @OA\Property(property="gst", type="string", example="", description="GST"),
 *             @OA\Property(property="service_charge", type="string", example="", description="Service Charge"),
 *             @OA\Property(property="coupon", type="string", example="", description="Coupon code"),
 *             @OA\Property(property="total", type="number", format="float", example=10100, description="Total amount"),
 *             @OA\Property(property="currency", type="string", example="INR", description="Currency code"),
 *             @OA\Property(
 *                 property="passengers",
 *                 type="array",
 *                 @OA\Items(
 *                     type="object",
 *                     @OA\Property(property="title", type="string", example="Mr", description="Passenger title"),
 *                     @OA\Property(property="first_name", type="string", example="Saurabh", description="Passenger first name"),
 *                     @OA\Property(property="last_name", type="string", example="Sharma", description="Passenger last name"),
 *                     @OA\Property(property="type", type="string", example="adult", description="Passenger type (e.g., adult, child)"),
 *                     @OA\Property(property="dob", type="string", example="1991-10-14", description="Date of birth in YYYY-MM-DD format"),
 *                     @OA\Property(property="nationality", type="string", example="IN", description="Passenger nationality"),
 *                     @OA\Property(property="passport_num", type="string", example="A100200300", description="Passport number")
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="client_details",
 *                 type="object",
 *                 @OA\Property(property="email", type="string", example="jack@mailinator.com", description="Client email"),
 *                 @OA\Property(property="phone", type="string", example="94827867565", description="Client phone number")
 *             ),
 *             @OA\Property(property="agent_reference", type="string", example="AGNT2000001", description="Agent reference number")
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="successful operation"
 *     )
 * )
 */

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id'                 => 'integer|required',
            'search_key.adult'          => 'integer|min:0|required',
            'search_key.infant'         => 'integer|min:0|required',
            'search_key.child'          => 'integer|min:0|required',
            'search_key.origin'         => 'string|required',
            'search_key.destination'    => 'string|required',
            'search_key.departure_date' => 'date|date_format:Y/m/d|required',
            'flight_keys'               => 'string|required',
            'sub_total'                 => 'numeric|required',
            'discount'                  => 'nullable|numeric',
            'gst'                       => 'required|numeric',
            'service_charge'            => 'nullable|numeric',
            'coupon'                    => 'nullable|string',
            'total'                     => 'numeric|required',
            'currency'                  => 'string|required',
            'passengers'                => 'array|required',
            'passengers.*.title'        => 'string|required',
            'passengers.*.first_name'   => 'string|required',
            'passengers.*.last_name'    => 'string|required',
            'passengers.*.type'         => 'string|in:adult,child,infant|required',
            'passengers.*.dob'          => 'date|date_format:Y-m-d|required',
            'passengers.*.nationality'  => 'string|required',
            'passengers.*.passport_num' => 'string',
            'client_details.email'      => 'email|required',
            'client_details.phone'      => 'string|required',
            'agent_reference'           => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => Constants::BAD_REQUEST,
                'status' => Constants::DEACTIVE_STATUS,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $adult                          = $request->search_key['adult'];
            $infant                         = $request->search_key['infant'];
            $child                          = $request->search_key['child'];
            $email                          = $request->client_details['email'];
            $phone                          = $request->client_details['phone'];
            $user_id                        = $this->checkUser($phone);
            $booking_no                     = 'SWT_'.date('ymdhis');;
            $booking                        = new Booking;
            $booking->user_id               = $user_id;
            $booking->booking_no            = $booking_no;
            $booking->vendor_id             = $request->vendor_id;
            $booking->email                 = $email;
            $booking->phone                 = $phone;
            $booking->no_of_audlts          = $adult;
            $booking->no_of_childrens       = $infant;
            $booking->no_of_infant          = $child;
            $booking->total_no_of_traveller = $adult + $infant + $child;
            $booking->origin                = $request->search_key['origin'];
            $booking->destination           = $request->search_key['destination'];
            $booking->departure_date        = date('Y-m-d', strtotime($request->search_key['departure_date']));
            $booking->coupon_code           = $request->coupon  ?? '';
            $booking->amount                = $request->sub_total ?? 0;
            $booking->discount              = $request->discount ?? 0;
            $booking->total                 = $request->total ?? 0;
            $booking->gst_no                = $request->gst_no ?? '';
            $booking->booking_data          = json_encode($request->all());
            $booking->booking_date          = date('y-m-d');
            $booking->save();
            if(!empty($request->passengers)){
                foreach($request->passengers as $passenger){
                    $passengerDetail                    = new PassengerDetails;
                    $passengerDetail->booking_id        = $booking->id;
                    $passengerDetail->type              = $passenger['type'];
                    $passengerDetail->title             = $passenger['title'];
                    $passengerDetail->first_name        = $passenger['first_name'];
                    $passengerDetail->last_name         = $passenger['last_name'];
                    $passengerDetail->dob               = date('Y-m-d',strtotime($passenger['dob']));
                    $passengerDetail->nationality       = $passenger['nationality'];
                    $passengerDetail->passport_num      = $passenger['passport_num'];
                    $passengerDetail->save();
                }
            }
            if (!empty($booking->id)) {
                return response()->json([
                    'code' => Constants::SUCCESS_REQUEST,
                    'status' => Constants::ACTIVE_STATUS,
                    'message' => __('message.booking_success'),
                    'booking_id' =>  $booking->id,
                    'booking_no' =>  $booking_no
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


    public function payment(Request $request){
        $validator = Validator::make($request->all(), [
            'booking_id'            => 'integer|required',
            'status'                => 'string|required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => Constants::BAD_REQUEST,
                'status' => Constants::DEACTIVE_STATUS,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $bookingDetails = Constants::BLANK_ARRAY;
            if($request->status == 'SUCCESS'){
                $bookingData = Booking::where(['id'=>$request->booking_id])->first();
                if(!empty($bookingData)){
                    $service = $this->getService($bookingData->vendor_id);
                    $ticket = $this->$service->bookTicket($bookingData);
                    prd($bookingData);
                }else {
                    return response()->json([
                        'code' => Constants::BAD_REQUEST,
                        'status' => Constants::DEACTIVE_STATUS,
                        'message' => __('message.booking_not_found'),
                    ]);
                }
            }else {
                return response()->json([
                    'code' => Constants::BAD_REQUEST,
                    'status' => Constants::DEACTIVE_STATUS,
                    'message' => __('message.payment_fail'),
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

    private function checkUser($phone){
        $user = User::where('phone_no', $phone)->first();
        if(!empty($user)){
            return $user->id;
        }else{
            $user                           = new User;
            $user->role                     = 2;
            $user->phone_no                 = $phone;
            $user->save();
            return $user->id;
        }
    }
    private function getService($vendor_id){
        $service = Constants::BLANK_STRING;
        $user = Vendor::select('service')->where('id', $vendor_id)->first();
        if(!empty($user)){
            $service = $user->service;
        }
        return $service;
    }

}
