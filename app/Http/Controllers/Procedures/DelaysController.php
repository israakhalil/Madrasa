<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Delays as DelaysModel;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DelaysController extends  Controller
{

    public function store(Request $request, $id = null)
    {
        $items=collect($request);
        foreach ($items as $item) {
            $item["delay_date"]= Carbon::parse($item["delay_date"]);
            DelaysModel::query()->Create((array)$item);
        }
        return response()->json([
            'msg' => "تمت الاضافة بنجاح",
            'code'=>StatusCodes::OK
        ]);
        
    }
}