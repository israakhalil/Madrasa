<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Leaves as LeavesModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DateTimeZone;

class LeavesController extends  Controller
{

    public function store(Request $request, $id = null)
    {
        // return $request;
        $items=collect($request);
        // foreach ($items as $item) {
        //     $item["leave_date"]= Carbon::parse($item["leave_date"]);
        //     $item["leave_time"] =Carbon::parse($item["leave_time"])->setTimezone('asia/jerusalem')->format('h:i:s'); 
        //     LeavesModel::query()->Create((array)$item);
        // }
        // return response()->json([
        //     'msg' => "تمت الاضافة بنجاح",
        //     'code'=>StatusCodes::OK
        // ]);
        

        
        foreach ($items as $item) {
            $item["leave_date"]= Carbon::parse($item["leave_date"]);
            $item["leave_time"] =Carbon::parse($item["leave_time"])->setTimezone('asia/jerusalem')->format('h:i:s'); 
            try {
                LeavesModel::query()->Create((array)$item);
            } catch (\Exception $exception) {
                   return response()->json([
                       'msg' => "هناك مشكلة",
                       'code'=>StatusCodes::GENERAL_ERROR
                   ]);            }

               }
           return response()->json([
               'msg' => "تمت الاضافة بنجاح",
               'code'=>StatusCodes::OK
           ]);


    }
}