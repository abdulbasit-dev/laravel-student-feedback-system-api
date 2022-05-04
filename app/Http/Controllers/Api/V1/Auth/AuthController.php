<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse as Json;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthController extends Controller
{
    public function login(Request $request): Json
    {
        //validation
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->error(422,$validator->errors()->all());
        }

        $credentials = $request->all();

        //check email
        $user = User::where('email', $credentials['email'])->get()->first();

        //check password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->error(401,__('api.wrong_credential'));
        }

        //create token
        $token = $user->createToken('myapitoken')->plainTextToken;
        $user["user_token"] = $token;

        return $this->josnResponse(true, "Login successfully.", Response::HTTP_OK, $user);
    }

    public function logout(): Json
    {
        auth()->user()->tokens()->delete();
        return $this->josnResponse(true, "Logout successfully.", Response::HTTP_OK);
    }

    public static function resetPassword(Request $request): Json
    {
        $messages = [
            'old_password.required' => __('api.old_password_req'),
            'new_password.required' => __('api.new_password_req'),
            'old_password.min' => __('api.old_password_min'),
            'new_password.min' => __('api.new_password_min'),
        ];
        //validation
        $validator = Validator::make($request->all(), [
            'old_password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8'],
        ], $messages);

        if ($validator->fails()) {
            return response()->error(422,$validator->errors()->all());
        }

        //get user
        $user = auth()->user();
        //check password
        if (!Hash::check($request->old_password, $user->password)){
            return response()->error(403,__('api.invalid_password'));
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return response()->success(200,__('api.password_reset_success'));
    }
}


