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
        $user = User::query()->where('email', $request->email)->first();
        $school=null;

        if($user->school_id != 0){

            $school= SchoolsModel::query()->where('id', $user->school_id)->first();

        }

        if (isset($user) && $this->password_check($request->password,$user)) {
            $token = $user->createToken('API TOKEN')->plainTextToken;

            return $this->sendLoginResponse($request, $user, $token,$school);
        }
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            $this->email() => ['required', 'string', 'max:255'],
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

        if($school){

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
        else{
            return response()->json([
                'status' => true,
                'data' => [
                    'token' => $token,
                    'user' => (new UserResource($user)),
                    'school' => ["name"=>"مدير النظام"]
                ],
            ]);
        }

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

    public function email()
    {
        return 'username';
    }

    protected function guard()
    {
        return Auth::guard('web');
    }
}
