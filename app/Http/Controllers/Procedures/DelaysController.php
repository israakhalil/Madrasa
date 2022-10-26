<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Delays as DelaysModel;
use App\Http\Resources\DelayResource;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DelaysController extends  Controller
{
    public function index(Request $request )
    {
    $items = DelaysModel::query()->filter()->orderBy('id', 'asc')->get();
    $data['delays']  = DelayResource::collection($items);
    return response()->json([
        'data' => $data,
        'code'=>StatusCodes::OK
    ]);
    }

    public function store(Request $request, $id = null)
    {
        $items=collect($request);
        foreach ($items as $item) {
            $item["delay_date"]= Carbon::parse($item["delay_date"]);
            try {
                DelaysModel::query()->Create((array)$item);
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
    public function save(Request  $request, $id = null)
    {
        $data = $request->only(DelaysModel::FILLABLE);
        $data["delay_date"]= Carbon::parse($data["delay_date"]);
        DelaysModel::query()->updateOrCreate(['id' => $id,], $data);
       
        return response()->json([
            'msg' => "تم الحفظ بنجاح",
            'code'=>StatusCodes::OK
        ]);   
     }
    public function delete($id)
    {
        $item = DelaysModel::query()->where('id' , '=', $id);
        $item->delete();
        return response()->json([
            'msg' => "تم الحذف بنجاح",
            'code'=>StatusCodes::OK
        ]);   
       
    }
}