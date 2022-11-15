<?php
namespace App\Http\Controllers\Auth;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Resources\PermissionResource;
use App\Models\Auth\Permission;
use Illuminate\Http\Request;


class PermissionsController extends  Controller
{
    public function index(Request $request )
    {
    $items = Permission::query()->filter()->orderBy('id', 'asc')->get();
    $data['Permissions']  = PermissionResource::collection($items);
    return response()->json([
        'data' => $data,
        'code'=>StatusCodes::OK
    ]);
    }
}