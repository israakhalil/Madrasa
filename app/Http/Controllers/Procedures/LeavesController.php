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
        foreach ($items as $item) {
            $item["leave_date"]= Carbon::parse($item["leave_date"]);
            $item["leave_time"] =Carbon::parse($item["leave_time"])->setTimezone('asia/jerusalem')->format('h:i:s'); 
            //  $test->format('h:i:s');
        //    return  $item["leave_time"];
            // $item["leave_time"]= Carbon::parse($item["leave_time"])->format('h:i:s');
            // $date=$item["leave_time"]->setTimezone('asia/jerusalem');
// return  $item["leave_time"];
            // $date = Carbon::createFromFormat('H:i:s', $item["leave_time"], 'asia/jerusalem');
            // return $date;
            // $date->setTimezone('UTC');
            
            // $date= ::convertToLocal($post->created_at, 'Y-m-d g:i', true);
            // return $date;
            // $item["leave_time"]= Carbon::parse($item["leave_time"])->format('h:i:s');

            LeavesModel::query()->Create((array)$item);
        }
        return response()->json([
            'msg' => "تمت الاضافة بنجاح",
            'code'=>StatusCodes::OK
        ]);
        
    }
}