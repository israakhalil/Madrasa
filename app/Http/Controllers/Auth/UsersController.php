<?php
namespace App\Http\Controllers\Auth;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Auth\User as UsersModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends  Controller
{
    public function index(Request $request )
    {
    $items = UsersModel::query()->filter()->orderBy('id', 'asc')->get();
    $data['Users']  = UserResource::collection($items);
    return response()->json([
        'data' => $data,
        'code'=>StatusCodes::OK
    ]);
    }


    public function store(Request  $request, $id = null)
    {
        $data = $request->only(UsersModel::FILLABLE);
        
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        UsersModel::query()->updateOrCreate(['id' => $id,], $data);
       
        return response()->json([
            'msg' => "تم الحفظ بنجاح",
            'code'=>StatusCodes::OK
        ]);   
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
}