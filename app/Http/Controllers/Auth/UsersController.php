<?php
namespace App\Http\Controllers\Auth;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Auth\Permission;
use App\Models\Auth\User as UsersModel;
use App\Models\Auth\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


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
    
        $Permission= Permission::query()->select("id")->whereIn('group', [2,3])->get();

        if($id){
            $user = UsersModel::query()->where('role_id', 2)->where('email', $request->email)->where('id','!=', $id)->first();
            if($user){return response()->json(['msg' => "هذا الاايميل موجود سابقا ",'code'=>StatusCodes::EMAIL_ERR]);}
            UsersModel::where('id', $id)->update(['name'=>$data['name'],'password'=>$data['password'],'school_id'=>$data['school_id']]);
            // $this->permissions()->sync($Permission);
            return response()->json(['msg' => "تم الحفظ بنجاح",'code'=>StatusCodes::OK]);
            }
        else{
            $userNew = UsersModel::query()->where('role_id', 2)-> where('email', $request->email)->first();
            if(isset($userNew)){ return response()->json([ 'msg' => "هذا الاايميل موجود سابقا ", 'code'=>StatusCodes::EMAIL_ERR ]);}
            $item=UsersModel::query()->Create($data);
            $item->permissions()->sync($Permission);
            return response()->json(['msg' => "تم الحفظ بنجاح",'code'=>StatusCodes::OK]);
            }
     }

    public function storeAdministrator( Request $request, $id = null)
    {
        $data = $request->only(UsersModel::FILLABLE);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
      
        if($id){
            $user = UsersModel::query()->where('role_id',  $request->role_id)->where('email', $request->email)->where('id','!=', $id)->first();
            if (isset($user)) { return response()->json(['msg' => "هذا الاايميل موجود سابقا ",'code'=>StatusCodes::EMAIL_ERR]);} 
            $item = UsersModel::query()->find($id);
            $item->update($data);
            // UsersModel::where('id', $id)->update($data);
            $item->classes()->sync($request->get('classesIds', []));
            // UserPermission::create([ 'user_id' =>$id,'permission_id' => 4,]);
            $item->permissions()->sync($request->get('permissionIds', []));

           return response()->json(['msg' => "تم الحفظ بنجاح", 'code'=>StatusCodes::OK ]);
           
        }
        else{
            $userNew = UsersModel::query()->where('role_id',  $request->role_id)->where('email', $request->email)->first();
            if(isset($userNew)){
                return response()->json(['msg' => "هذا الاايميل موجود سابقا ",'code'=>StatusCodes::EMAIL_ERR]);
            }
            
            $data['school_id']=request()->header('School_id');
            $item=UsersModel::query()->Create($data);
            $item->classes()->sync($request->get('classesIds', []));
            
            $item->permissions()->sync($request->get('permissionIds', []));
            // return $request->get('permissionIds', []);
            return response()->json([ 'msg' => "تم الحفظ بنجاح", 'code'=>StatusCodes::OK ]);
          
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

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $data = $request->only(['name', 'email']);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'code'=>StatusCodes::VALIDATION_ERROR, 'msg'=>$validator->errors()->first(), []]);
        }
 
        $_user = UsersModel::query()->where('role_id',  $user->role_id)->where('email', $data['email'])->where('id','!=', $user->id)->first();

        if (isset($_user)) {
            return response()->json([
                'msg' => "هذا الاايميل موجود سابقا ",
                'code'=>StatusCodes::VALIDATION_ERROR
            ]);
        }

        
        $user->update($data);
        return response()->json(['status'=>true, 'code'=>StatusCodes::OK, Enum::DONE_SUCCESSFULLY, 'data'=>(new UserResource($user)) , 'msg'=>"تمت العملية بنجاح"]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6',
            'password' => 'required|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'code'=>StatusCodes::VALIDATION_ERROR, 'msg'=>$validator->errors()->first(), []]);
        }
        
        if (Hash::check($request->old_password, $user->getAuthPassword())) {
            $user->password = Hash::make($data['password']);
            $user->save();
            return response()->json(['true'=>false,'code'=>StatusCodes::OK, Enum::UPDATED_SUCCESSFULLY, (new UserResource($user)), 'msg'=>"تمت العملية بنجاح"] );

        } else {
            return response()->json(['status'=>false,'code'=>StatusCodes::VALIDATION_ERROR, 'msg'=>"كلمة المرور القديمة غير صحيحة" ]);

        }
    }
}
