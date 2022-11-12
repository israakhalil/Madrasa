<?php
namespace App\Http\Controllers\Auth;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Auth\User as UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends  Controller
{
    public function supervisors(Request $request )
    {
        $request['role_id'] =2;
    $items = UsersModel::query()->filter()->orderBy('id', 'asc')->get();

    $data['Users']  = UserResource::collection($items);
    return response()->json([
        'data' => $data,
        'code'=>StatusCodes::OK
    ]);
    }
    public function administrators(Request $request )
    {
        $request['school_id']= request()->header('School_id');
        $request['role_id'] =3;
        $items = UsersModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['Users']  = UserResource::collection($items);
        return response()->json([
            'data' => $data,
            'code'=>StatusCodes::OK
        ]);
    }

    public function storeSupervisor(Request  $request, $id = null)
    {
        $data = $request->only(UsersModel::FILLABLE);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

           $userNew = UsersModel::query()->where('role_id', 2)
                ->where('email', $request->email)->where('school_id', $request->school_id)->first();

        if($id){
            $user = UsersModel::query()->where('id', $id)->first();

            if( $data['email']== $user->email){
                if( $data['school_id']== $user->school_id){
//                    return $user;
                    UsersModel::where('id', $id)->update(['name'=>$data['name'],'password'=>$data['password']]);
                    return response()->json([
                        'msg' => "تم الحفظ بنجاح",
                        'code'=>StatusCodes::OK
                    ]);
                }
                else{
                    $userNew = UsersModel::query()->where('role_id', 2)-> where('school_id', $request->school_id)->first();
                    if($this->check_school($userNew , $data)){
                        return response()->json([
                            'msg' => "هناك مشرف على هذه المدرسة",
                            'code'=>StatusCodes::ROLE_ERR
                        ]);
                    }
                    else{

                        UsersModel::where('id', $id)->update(
                            ['name'=>$data['name'],
                            'password'=>$data['password'],
                            'school_id'=>$data['school_id']]);
                        return response()->json([
                            'msg' => "تم الحفظ بنجاح",
                            'code'=>StatusCodes::OK
                        ]);
                    }
                }
            }
            else{
                $userNew = UsersModel::query()->where('role_id', 2)-> where('email', $request->email)->first();

                if($this->check_email($userNew, $data)){
                    return response()->json([
                        'msg' => "هذا الاايميل موجود سابقا ",
                        'code'=>StatusCodes::EMAIL_ERR
                    ]);
                }
                else{
                    UsersModel::where('id', $id)->update([
                        'name'=>$data['name'],
                        'school_id'=>$data['school_id'],
                        'email'=>$data['email'],
                        'password'=>$data['password']]);

                    return response()->json([
                        'msg' => "تم الحفظ بنجاح",
                        'code'=>StatusCodes::OK
                    ]);
                }
            }

        }
        else{
            $userNew = UsersModel::query()->where('role_id', 2)-> where('email', $request->email)->first();

            if($this->check_email($userNew, $data)){
                return response()->json([
                    'msg' => "هذا الاايميل موجود سابقا ",
                    'code'=>StatusCodes::EMAIL_ERR
                ]);
            }
            $userNew = UsersModel::query()->where('role_id', 2)-> where('school_id', $request->school_id)->first();

            if( $this->check_school($userNew, $data)){
                return response()->json([
                    'msg' => "هناك مشرف على هذه المدرسة",
                    'code'=>StatusCodes::ROLE_ERR
                ]);
            }
            else{
                UsersModel::query()->Create($data);

                return response()->json([
                    'msg' => "تم الحفظ بنجاح",
                    'code'=>StatusCodes::OK
                ]);
            }


        }

     }
    public function storeAdministrator( Request $request, $id = null)
    {
        $data = $request->only(UsersModel::FILLABLE);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        if($id){
            $user = UsersModel::query()->where('role_id',  $request->role_id)->where('email', $request->email)->where('id', $id)->first();
            if( isset($user)){
                $user->update($data);
                $user->classes()->sync($request->get('classesIds', []));
                return response()->json([
                    'msg' => "تم الحفظ بنجاح",
                    'code'=>StatusCodes::OK
                ]);
            }
            else{
                $user = UsersModel::query()->where('role_id',  $request->role_id)->where('email', $request->email)->first();
                if (isset($user) && $user->email == $request->email) {
                    return response()->json([
                        'msg' => "هذا الاايميل موجود سابقا ",
                        'code'=>StatusCodes::EMAIL_ERR
                    ]);
                } else {
                    $user->update($data);
                    $user->classes()->sync($request->get('classesIds', []));
                    return response()->json([
                        'msg' => "تم الحفظ بنجاح",
                        'code'=>StatusCodes::OK
                    ]);
                }
            }
        }
        else{
            $userNew = UsersModel::query()->where('role_id',  $request->role_id)->where('email', $request->email)->first();

            if($this->check_email($userNew, $data)){
                return response()->json([
                    'msg' => "هذا الاايميل موجود سابقا ",
                    'code'=>StatusCodes::EMAIL_ERR
                ]);
            }
            else{
                $data['school_id']=request()->header('School_id');
                $item=UsersModel::query()->Create($data);
                $item->classes()->sync($request->get('classesIds', []));

                return response()->json([
                    'msg' => "تم الحفظ بنجاح",
                    'code'=>StatusCodes::OK
                ]);
            }
        }

    }

    function check_school($user, $data){
        if( isset($user)  && $user->school_id == $data['school_id'] ) {
            return true;
        } else {
            return false;
        }
    }
    function check_email($user, $data)
    {
        if (isset($user) && $user->email == $data['email']) {
            return true;
        } else {
            return false;
        }
    }
    public function delete($id)
    {
        $item = UsersModel::query()->where('id' , '=', $id);

        $item->delete();
        return response()->json([
            'msg' => "تم الحذف بنجاح",
            'code'=>StatusCodes::OK
        ]);

    }

    public function fetchUserData(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['status'=>false, 'code'=>StatusCodes::UNAUTHORIZED, Enum::UNAUTHORIZED]);
        }
        return response()->json(['status'=>true, 'code'=>StatusCodes::OK, Enum::DONE_SUCCESSFULLY, 'data'=>(new UserResource($user)) ]);

    }
}
