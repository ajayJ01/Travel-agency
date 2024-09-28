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

class ForgetPasswordController extends Controller
{

    public function sendForgetCodeEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 200,
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'code' => 401,
                'status' => 0,
                'message' => __('message.user_does_not_exists'),
            ]);
        }

        PasswordReset::where('email', $user->email)->delete();
        $code = verificationCode(6);
        $password = new PasswordReset();
        $password->email = $user->email;
        $password->token = $code;
        $password->created_at = \Carbon\Carbon::now();
        $password->save();

        $type = 'PASS_RESET_CODE';
        $message['user_name'] = $user->name;
        $code = '<a href="' . url('password-forgot', $password->token) . ' ">Password Reset</a>';

        $shortCodes = [
            'code' => $code,

        ];
        sendTempEmail($user, $type, $shortCodes);
        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => __('message.password_reset_email_sent_successfully'),
        ]);
    }

    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 200,
                'status' => 0,
                'message' => $validator->errors()->first()
            ]);
        }
        $code =  $request->code;

        if (PasswordReset::where('token', $code)->where('email', $request->email)->count() != 1) {
            return response()->json([
                'code' => 200,
                'status' => 1,
                'message' => __('message.invalid_token'),
            ]);
        }

        return response()->json([
            'code' => 200,
            'status' => 1,
            'message' => __('message.you_can_change_your_password'),
            'data' => [
                'token' => $code,
                'email' => $request->email,
            ]
        ]);
    }
}
