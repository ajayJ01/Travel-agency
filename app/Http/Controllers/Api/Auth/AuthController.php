<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    // Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|integer|unique:users',
            'country_code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 200,
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }
       $otp = rand(1111, 9999);
        try {

            $user = new User;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->country_code = $request->country_code;
            $user->email = $request->email;
            $user->otp = $otp;
            $user->password = Hash::make($request->password);
            $user->device_id = $request->device_id;
            $user->device_type = $request->device_type;
            $user->fcm_token = $request->fcm_token;
            $user->login_type = $request->login_type;
            $user->save();


            if ($user) {

                //send verify mail to user
                $subject = "Login verify";
                $message['user_name'] = $user->first_name . ' ' . $user->last_name;
                $message['otp'] = $otp;
                sendEmail($user->email, $subject, $message);
            }

            return response()->json([
                'code' => 200,
                'status' => 1,
                'message' => __('message.register_successfully_send_an_activation_code'),
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 401,
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }

    // Login
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 200,
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }
        try {


            if ($request->type == "email") {

                $credentials = request(['email', 'password']);

                if (!Auth::attempt($credentials)) {
                    return response()->json([
                        'code' => 401,
                        'status' => 0,
                        'message' => 'The provided credentials are incorrect',
                    ]);
                }

                $user = $request->user()->load('vendorDetail');


                if (!$user->is_verified) {
                    $userData = User::where('id', $user->id)->first();
                    $otp = rand(1111, 9999);
                    $userData->otp = $otp;
                    $userData->save();

                    $subject = "Login Verify";
                    $message = [
                        'user_name' => $userData->name,
                        'otp' => $otp,
                    ];
                    sendEmail($userData->email, $subject, $message);
                    $user->otp = $otp;
                    return response()->json([
                        'code' => 200,
                        'status' => 1,
                        'message' => __('message.please_verify_your_email'),
                        'data' => $user
                    ]);
                }
                $user->device_id = $request->device_id;
                $user->device_type = $request->device_type;
                $user->fcm_token = $request->fcm_token;
                $user->login_type = $request->login_type;
                $user->save();
                $user->photo = getImage(imagePath()['profile']['user']['path'] . '/' . $user->photo);
                if(!empty($user->vendorDetail->photo)){
                    $user->vendorDetail->photo = getImage(imagePath()['profile']['user']['path']. '/'.$user->vendorDetail->photo);
                }
                $user['is_subscribe'] = isSubscribe();
                $user['limit'] = carLimit();
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'code' => 200,
                    'status' => 1,
                    'message' => __('message.login_successfully'),
                    'token' =>  $token,
                    'data' => $user
                ]);
            } else if ($request->type === 'phone') {
                $validator = Validator::make($request->all(), [
                    'country_code' => 'required',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'code' => 200,
                        'status' => 0,
                        'message' => $validator->errors()->first()
                    ]);
                }
                $userphone =  User::where('phone', $request->email)->with('vendorDetail')->first();
                if (!empty($userphone)) {
                    $otp = rand(1111, 9999);
                    $userphone->otp = $otp;
                    $userphone->save();
                    return response()->json([
                        'code' => 200,
                        'status' => 1,
                        'message' => __('message.verify_otp'),
                        'data' => $userphone
                    ]);
                }else{
                    $otp = rand(1111, 9999);
                    $user = new User;
                    $user->phone = $request->email;
                    $user->otp = $otp;
                    $user->password = Hash::make($request->password);
                    $user->device_id = $request->device_id;
                    $user->country_code = $request->country_code;
                    $user->device_type = $request->device_type;
                    $user->fcm_token = $request->fcm_token;
                    $user->login_type = $request->login_type;
                    $user->save();
                    return response()->json([
                        'code' => 200,
                        'status' => 1,
                        'message' => __('message.user_successfully_update'),
                        'data' =>  $user
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 401,
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'         => 'required',
            'password'       => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 200,
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $user  = User::where('id', $request->user_id)->first();
            if (empty($user)) {
                return response()->json([
                    'code' => 401,
                    'status' => 0,
                    'message' => __('message.user_does_not_exists'),
                ]);
            }
            $user->password = Hash::make($request->password);
            $user->save();
            if ($user) {
                return response()->json([
                    'code' => 200,
                    'status' => 1,
                    'message' => __('message.password_change_successfully'),
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

    public function sendForgetCodeEmail(Request $request)
    {
        // prd($request->email);
        $validator = Validator::make($request->all(), [
            'email' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 200,
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }
        $userData = User::where('email', $request->email)->first();
        if (empty($userData)) {
            return response()->json([
                'code' => 401,
                'status' => 0,
                'message' => __('message.user_not_found'),
            ]);
        }
        try {
            // $user = User::create([
            //     'email' => $request->email,

            // ]);

            // if ($user) {
            //     //generate token for verify email
            //     $verifyUser = PasswordReset::where(['email' => $user->email])->first(['id']);
            //     if (empty($verifyUser)) {
            //         $verifyUser         = new PasswordReset();
            //         $verifyUser->email  = $user->email;
            //         $verifyUser->token   = str_random(40);
            //         $verifyUser->save();
            //     }

            //     //send verify mail to user
            //     $subject = "login verify";
            //     $message['user_name'] = $user->name;
            //     $message['url'] = url('user/verify', $verifyUser->token);
            //     sendEmail($user->email, $subject, $message);
            // }

            return response()->json([
                'code' => 200,
                'status' => 1,
                'message' => __('message.register_successfully_send_an_activation_code'),
                'data' => $user,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 401,
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        $notify = __('message.logout_succesfully');
        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => $notify,
        ]);
    }

    public function unauthenticate()
    {
        $notify = __('message.unauthenticated_user');
        return response()->json([
            'code' => 403,
            'status' => 0,
            'message' => $notify
        ]);
    }
    public function verifyuserOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'otp' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 200,
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        try {

            $userData = User::where('id', $request->user_id)->first();
            if (empty($userData)) {
                return response()->json([
                    'code' => 401,
                    'status' => 0,
                    'message' => __('message.user_not_found'),
                ]);
            }
            if ($userData->otp != $request->otp) {
                return response()->json([
                    'code' => 401,
                    'status' => 0,
                    'message' => __('message.otp_not_match'),
                ]);
            }
            $userData->verified_at = now();
            $userData->is_verified = 1;
            $userData->otp = null;
            $userData->save();

            $token = $userData->createToken('auth_token')->plainTextToken;


            return response()->json([
                'code' => 200,
                'status' => 1,
                'message' => __('message.verified_otp_updated_successfully'),
                'token' =>  $token,
                'data' => $userData

            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 401,
                'status' => 0,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
