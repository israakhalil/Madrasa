<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Leaves as LeavesModel;
use App\Http\Resources\LeaveResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTimeZone;

class LeavesController extends  Controller
{

    public function index(Request $request )
    {
    $items = LeavesModel::query()->filter()->orderBy('id', 'asc')->get();
    $data['leaves']  = LeaveResource::collection($items);
    return response()->json([
        'data' => $data,
        'code'=>StatusCodes::OK
    ]);
    }

    public function store(Request $request, $id = null)
    {
        // return $request;
        $items=collect($request);
        foreach ($items as $item) {
            $item["leave_date"]= Carbon::parse($item["leave_date"]);
            $item["leave_time"] =Carbon::parse($item["leave_time"])->setTimezone('asia/jerusalem')->format('h:i:s'); 
            try {
                LeavesModel::query()->Create((array)$item);
            } catch (\Exception $exception) {
                   return response()->json([
                    'msg' => "يجب ادخال جميع الحقول",
                    'code'=>StatusCodes::GENERAL_ERROR
                   ]);            }

               }
           return response()->json([
               'msg' => "تمت الاضافة بنجاح",
               'code'=>StatusCodes::OK
           ]);


    }

    public function save(Request  $request, $id = null)
    {
        $data = $request->only(LeavesModel::FILLABLE);
        $data["leave_date"]= Carbon::parse($data["leave_date"]);
        $data["leave_time"] =Carbon::parse($data["leave_time"])->setTimezone('asia/jerusalem')->format('h:i:s'); 

        LeavesModel::query()->updateOrCreate(['id' => $id,], $data);
       
        return response()->json([
            'msg' => "تم الحفظ بنجاح",
            'code'=>StatusCodes::OK
        ]);   
     }

    public function delete($id)
    {
        $item = LeavesModel::query()->where('id' , '=', $id);
        $item->delete();
        return response()->json([
            'msg' => "تم الحذف بنجاح",
            'code'=>StatusCodes::OK
        ]);   
       
    }
}