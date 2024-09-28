<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Constants\Constants;
use App\Models\Airline\Airline;
use App\Models\Pages\Page;
use App\Models\Questions;
use App\Models\Ticket\SupportAttachment;
use App\Models\Ticket\SupportMessage;
use App\Models\Ticket\SupportTicket;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OA;

class BasicController extends Controller
{

    /**
     * @OA\Get(
     *     path="/swadesitravel/webview/public/api/airline",
     *     tags={"Basics"},
     *     summary="Get All Airlines",
     *     description="Get all Airlines by this API",
     *     operationId="getAirlines",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status values that needed to be considered for filter",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="available",
     *             type="string",
     *             enum={"available", "pending", "sold"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */


     public function getAirlines()
     {
         try {
             $cacheTTL = Constants::AIRLINE_CACHE_TIME;
             $cacheKey = Constants::AIRLINE_CACHE_KEY;
             $airlines = Cache::get($cacheKey);
             if (empty($airlines)) {
                 $airlines = Airline::select('id','name','code','image')->orderBy('name')->get();
                 if (!$airlines->isEmpty()) {
                     foreach($airlines as $airline){
                         $airline->image = getImage(imagePath()['airline']['path'] . '/' . $airline->image);
                        }
                     Cache::put($cacheKey, $airlines, $cacheTTL);
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
                 'message' => __('message.airlines_list'),
                 'data' => $airlines,
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
     * @OA\Get(
     *     path="/swadesitravel/webview/public/api/faq",
     *     tags={"Basics"},
     *     summary="Get All FAQ's",
     *     description="Get all FAQ'd by this API",
     *     operationId="getFaq",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status values that needed to be considered for filter",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="available",
     *             type="string",
     *             enum={"available", "pending", "sold"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */


     public function getFaq()
     {
         try {
            $cacheTTL = Constants::FAQS_CACHE_TIME;
            $cacheKey = Constants::FAQS_CACHE_KEY;
            $faqs = Cache::remember($cacheKey, $cacheTTL, function () {
                return Questions::where(['status' => '1'])
                                ->select('id', 'question', 'answer')
                                ->orderBy('id', 'ASC')
                                ->paginate(10);
            });
             if (!empty($faqs)) {
                 return response()->json([
                     'code' => 200,
                     'status' => 1,
                     'message' => __('message.faq_list'),
                     'data' =>  $faqs
                 ]);
             } else {
                 return response()->json([
                     'code' => 200,
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
 *     path="/swadesitravel/webview/public/api/customer-support",
 *     tags={"Basics"},
 *     summary="Customer Support",
 *     description="This API is for searching flights according to the origin and destination",
 *     operationId="customerSupport",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 @OA\Property(property="name", type="string", example="Jack", description="Customer name"),
 *                 @OA\Property(property="email", type="string", example="abc@mailinator.com", description="Customer email"),
 *                 @OA\Property(property="subject", type="string", example="consectetur adipiscing elit", description="Subject of the customer support message"),
 *                 @OA\Property(property="message", type="string", example="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer rhoncus metus lobortis, pulvinar nisl rhoncus, lacinia enim", description="Customer message"),
 *                 @OA\Property(property="priority", type="integer", example=1, description="Priority level of the message"),
 *                 @OA\Property(
 *                     property="attachments",
 *                     type="array",
 *                     @OA\Items(
 *                         type="string",
 *                         format="binary"
 *                     ),
 *                     description="Array of attachment files"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="successful operation"
 *     )
 * )
 */


    public function customerSupport(Request $request)
    {
        $ticket = new SupportTicket();
        $message = new SupportMessage();
        $files = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf','doc','docx');
        $validator = Validator::make($request->all(), [
            'attachments' => [
                'max:4096',
                function ($attribute, $value, $fail) use ($files, $allowedExts) {
                    foreach ($files as $file) {
                        $ext = strtolower($file->getClientOriginalExtension());
                        if (($file->getSize() / 1000000) > 2) {
                            return $fail("Miximum 2MB file size allowed!");
                        }
                        if (!in_array($ext, $allowedExts)) {
                            return $fail("Only png, jpg, jpeg, pdf, doc, docx files are allowed");
                        }
                    }
                    if (is_array($files) && count($files) > 5) {
                        return $fail("Maximum 5 files can be uploaded");
                    }
                },
            ],
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
            'priority' => 'required|in:1,2,3'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 200,
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $random = rand(100000, 999999);
            $ticket->ticket = $random;
            $ticket->name = $request->name;
            $ticket->email = $request->email;
            $ticket->subject = $request->subject;
            $ticket->subject = $request->message;
            $ticket->priority = $request->priority;
            $ticket->save();
            $path = imagePath()['ticket']['path'];
            if ($request->hasFile('attachments')) {
                foreach ($files as  $file) {
                    try {
                        $attachment = new SupportAttachment();
                        $attachment->support_ticket_id = $ticket->id;
                        $attachment->attachment = uploadFile($file, $path);
                        $attachment->save();
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Could not upload your file'];
                        return back()->withNotify($notify);
                    }
                }
            }
            if (!empty($ticket->id)) {
                return response()->json([
                    'code' => 200,
                    'status' => 1,
                    'message' => __('message.support_success'),
                    'ticket_id' =>  $ticket->id
                ]);
            } else {
                return response()->json([
                    'code' => 200,
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
     * @OA\Get(
     *     path="/swadesitravel/webview/public/api/page",
     *     tags={"Basics"},
     *     summary="Get Page Content",
     *     description="Get all FAQ'd by this API",
     *     operationId="getPages",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Status values that needed to be considered for filter",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="available",
     *             type="string",
     *             enum={"available", "pending", "sold"},
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     )
     * )
     */

    public function getPages($slug)
	{
		try {
			$data       = [];
			$title      = '';
			$content    = '';
            $pageData   = Page::where('page_slug', $slug);
            $title      = $pageData->data_values->heading;
            $content    = $pageData->data_values->details;
            if(empty($title)){
				$message = 'Data not found';
				$data =  [];
			}else{
				$message = 'Data found';
				$data['title'] =  $title;
				$data['content'] =  $content;
			}
			return response()->json([
				'code' => 200,
				'status' => 1,
				'message' => $message,
				'data' => $data
			]);

		} catch (Exception $e) {

			return response()->json([
				'code' => 401,
				'status' => 0,
				'message' => $e->getMessage(),
			]);
		}
	}
}
