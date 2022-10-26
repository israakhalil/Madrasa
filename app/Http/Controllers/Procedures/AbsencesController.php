<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Absences as AbsencesModel;
use App\Http\Resources\AbsenceResource;

use Illuminate\Http\Request;
use Carbon\Carbon;


class AbsencesController extends  Controller
{
    public function index(Request $request )
    {
    $items = AbsencesModel::query()->filter()->orderBy('id', 'asc')->get();
    $data['absences']  = AbsenceResource::collection($items);
    return response()->json([
        'data' => $data,
        'code'=>StatusCodes::OK
    ]);
    }

    public function store(Request $request, $id = null)
    {
        $items=collect($request);
        foreach ($items as $item) {
             $item["absence_date"]= Carbon::parse($item["absence_date"]);
             try {
                AbsencesModel::query()->Create((array)$item);
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
        $data = $request->only(AbsencesModel::FILLABLE);
        $data["absence_date"]= Carbon::parse($data["absence_date"]);
        AbsencesModel::query()->updateOrCreate(['id' => $id,], $data);
       
        return response()->json([
            'msg' => "تم الحفظ بنجاح",
            'code'=>StatusCodes::OK
        ]);   
     }
    public function delete($id)
    {
        $item = AbsencesModel::query()->where('id' , '=', $id);
        // if (!$item) {
        //     return response()->json([
        //         'msg' => "هناك مشكلة",
        //         'code'=>StatusCodes::GENERAL_ERROR
        //     ]); 
        // }

        $item->delete();
        return response()->json([
            'msg' => "تم الحذف بنجاح",
            'code'=>StatusCodes::OK
        ]);   
       
    }
}