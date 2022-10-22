<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Violations as ViolationsModel;
use Illuminate\Http\Request;
use Carbon\Carbon;


class ViolationsController extends  Controller
{

    public function store(Request $request, $id = null)
    {
        $items=collect($request);
        // foreach ($items as $item) {
        //     $item["violation_date"]= Carbon::parse($item["violation_date"]);
        //     ViolationsModel::query()->Create((array)$item);
        // }
        // return response()->json([
        //     'msg' => "تمت الاضافة بنجاح",
        //     'code'=>StatusCodes::OK
        // ]);
        

        foreach ($items as $item) {
            $item["violation_date"]= Carbon::parse($item["violation_date"]);
            try {
                ViolationsModel::query()->Create((array)$item);
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