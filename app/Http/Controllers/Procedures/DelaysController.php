<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Delays as DelaysModel;
use App\Http\Resources\DelayResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
        // $data = $request->only(DelaysModel::FILLABLE);
        $filename=null; $path=null;
        if ($request->hasFile('attached')) {
            $file = $request->attached;
            $path=request()->header('School_id')
            . "/delays"
            .'/'. now()->format('Y')
            . '/'.now()->format('n')
            . '/'.now()->format('j');
            $filename=$file->getClientOriginalName();
            $path= Storage::disk('public')->putFileAs($path,$file ,$filename);
        }
        $data =(array) json_decode($request->data);
        if($path){$data["attached"]=  @$path;}
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