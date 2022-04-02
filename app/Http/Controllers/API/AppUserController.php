<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppUserProfileResource;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AppUserController extends Controller
{
    public function register(Request $request)
    {
        //        dd($request->all());
        //        if (!$validatedData){
        //            return response()->json($validatedData->messages(), 422);
        //        }
        //            $validatedData['password'] = bcrypt($request->password);

        $validator = Validator::make($request->all(), [

            'email' => 'required|unique:app_users,email',

            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = bcrypt($request->input('password'));

        if ($validator->fails()) {
            return response()->json(['error_code' => '1', 'message' => 'The email has already been taken'],  422);
        } else {
            $user = AppUser::create([
                'email' => $email,
                'password' => $password,
            ]);

            $accessToken = $user->createToken('authToken')->accessToken;

            return response()->json(['error_code' => '0', 'user' => $user, 'access_token' => $accessToken, 'message' => 'Register successfully'], 200);
        }
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('user')->attempt($loginData)) {
            $accessToken = Auth::guard('user')->user()->createToken('authToken')->accessToken;

            return response()->json(['error_code' => '0', 'access_token' => $accessToken, 'message' => 'Login successfully']);
        } else {
            return response()->json(['error_code' => '1', 'message' => 'Invalid Credentials'],  403);
        }
    }

    public function profile()
    {
        $user = Auth::guard('user-api')->user();
        $app_user = AppUser::find($user->id);

        if (!$app_user) {
            return response()->json(['error_code' => '1', 'message' => 'Invalid Credentials'],  403);
        }

        return new AppUserProfileResource($app_user);
    }
}
