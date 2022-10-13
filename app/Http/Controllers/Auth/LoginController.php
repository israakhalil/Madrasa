<?php

namespace App\Http\Controllers\Auth;

use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Auth\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\School\Schools as SchoolsModel;
use App\Http\Resources\SchoolResource;


class LoginController extends Controller
{


     use AuthenticatesUsers;

    public function login(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'username' => 'required|numeric',
        //     'password' => 'required',
        //   ]);
      
        //   if ($validator->fails()) {
        //     return response()->json(['code' => 401, 'msg' => $validator->errors()->first()]);
        //   }
      
      
        //   $user = User::where('username', $request->username)->first();
      
      
        //   if (!$user || !Hash::check($request->password, $user->password)) {
        //     return response()->json(['code' => 401, 'msg' => 'خطأ! تأكد من اسم المستخدم او كلمة المرور ']);
        //   }
        //   $token = $user->createToken('API TOKEN')->plainTextToken;
        //   return $this->sendLoginResponse($request, $user, $token);
        // }


        $user = User::query()->where('username', $request->username)->first();
        $school= SchoolsModel::query()->where('id', $user->school_id)->first();

        if (isset($user) && ($request->password== $user->password)) {
            $token = $user->createToken('API TOKEN')->plainTextToken;

            return $this->sendLoginResponse($request, $user, $token,$school);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            $this->username() => ['required', 'string', 'max:255'],
            'password' => ['required', 'min:6'],
        ]);
    }

    protected function password_check($password, $user)
    {
        return Hash::check($password, $user->password);
    }


    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );
        return response()->json([
            'status' => false,
            'code' => Response::HTTP_TOO_MANY_REQUESTS,
            // 'message' => ('auth.throttle', [
            //     'seconds' => $seconds,
            //     'minutes' => ceil($seconds / 60),
            // ]),
            'data' => [],
        ])->setStatusCode(Response::HTTP_TOO_MANY_REQUESTS);
    }

    protected function sendLoginResponse(Request $request, $user, $token,$school)
    {
        $this->clearLoginAttempts($request);

        return response()->json([
            'status' => true,
            'code' => StatusCodes::OK,
            'message' => ('messages.done_successfully'),
            'data' => [
                'token' => $token,
                'user' => (new UserResource($user)),
                'school' => (new SchoolResource($school)),
            ],
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        return response([
            'status' => false,
            'code' => StatusCodes::VALIDATION_ERROR,
            'message' => ('auth.failed'),
            'data' => [],
        ])->setStatusCode(StatusCodes::VALIDATION_ERROR);
    }

    public function logout(Request $request)
    {
        if ($request->user()){
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'status' => true,
            'code' => StatusCodes::OK,
            'message' => ('auth.logout'),
            'data' => [],
        ]);
    }

    public function username()
    {
        return 'username';
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}