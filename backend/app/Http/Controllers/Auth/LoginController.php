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
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{


     use AuthenticatesUsers;

    public function login(Request $request)
    {
        $user = User::query()->where('email', $request->email)->first();
        $school=null;

       
        if (isset($user) && $this->password_check($request->password,$user)) {

            if($user->school_id != 0){

                $school= SchoolsModel::query()->where('id', $user->school_id)->first();
    
            }
    
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
        return response()->json(['msg' => "خطأ في ايميل المستخدم او كلمة المرور",

         'status'=>false ]);
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

    public function forget(Request $request)
    {
        $request->validate([
            'email'=>['required', 'string', 'max:255'],
        ]);

        $user = User::query()->where('email', $request->email)->first();


        if(!$user){
         
            return response()->json([
                'msg' => 'تم ارسال  كلمة السر الي الايميل',
                'status' => 200
            ]);
        }
        else{
            $random=rand(1111111,9999999);
            $user->password = Hash::make($random);
            if($user->save())
            {
                $userData =array(
                    'email'=>$user->email,
                    'name'=>$user->name,
                    'password'=>$random );
         
                Mail::send('emails.reset' ,$userData, function($message) use($userData) {
                    $message->from('no-replay@moqsit.com','Password Request');
                    $message->to($userData['email'], $userData['name']) ;
                    $message->subject("Reset Password") ;
                });

                if(Mail::flushMacros()){
                    return response()->json([
                        'msg' => 'هناك خطأ',
                        'status' => 500
                    ]); 
                }else{
                    return response()->json([
                        'msg' => 'تم ارسال  كلمة السر الي الايميل',
                        'status' => 200
                    ]); 
                }
        }
        else{
            return response()->json([
                'msg' => 'هناك خطأ',
                'status' => 500
            ]); 
        }
    }
    }

}
