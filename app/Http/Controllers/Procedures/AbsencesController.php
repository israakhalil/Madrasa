<?php
namespace App\Http\Controllers\Procedures;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Absences as AbsencesModel;
use App\Http\Resources\AbsenceResource;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
        // $items=collect($request);
        // foreach ($items as $item) {
        //     $filename=null; $path=null;
        // if ($item->attached) {
        //     $file = $item->attached;
        //     $path=request()->header('School_id')
        //     . "/absences"
        //     .'/'. now()->format('Y')
        //     . '/'.now()->format('n')
        //     . '/'.now()->format('j');
        //     $filename=$file->getClientOriginalName();
        //     $path= Storage::disk('public')->putFileAs($path,$file ,$filename);
        // }
        // // $data =(array) json_decode($request->data);
        // if($path){$item["attached"]=  @$path;}

        $items=collect($request);
        foreach ($items as $item) {
             $item["absence_date"]= Carbon::parse($item["absence_date"]);
             try {
                AbsencesModel::query()->Create((array)$item);
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
        $filename=null; $path=null;
        if ($request->hasFile('attached')) {
            $file = $request->attached;
            $path=request()->header('School_id')
            . "/absences"
            .'/'. now()->format('Y')
            . '/'.now()->format('n')
            . '/'.now()->format('j');
            $filename=$file->getClientOriginalName();
            $path= Storage::disk('public')->putFileAs($path,$file ,$filename);
        }
        $data =(array) json_decode($request->data);
        if($path){$data["attached"]=  @$path;}
        $data["absence_date"]= Carbon::parse($data["absence_date"]);
        AbsencesModel::query()->updateOrCreate(['id' => $id,],$data);

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