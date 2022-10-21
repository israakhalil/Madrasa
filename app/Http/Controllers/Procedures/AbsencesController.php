<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Absences as AbsencesModel;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AbsencesController extends  Controller
{



    public function store(Request $request, $id = null)
    {
        $items=collect($request);
        foreach ($items as $item) {
            // return (array)$item;
             $item["absence_date"]= Carbon::parse($item["absence_date"]);
            AbsencesModel::query()->Create((array)$item);
        }
       

            // $data = $request->only(AbsencesModel::FILLABLE);
            // return $request;
            // $data["absence_date"]= Carbon::parse($data["absence_date"]);
            // AbsencesModel::query()->Create($data);
            return response()->json([
                'msg' => "تمت الاضافة بنجاح",
                'code'=>StatusCodes::OK
            ]);
        
    }
}