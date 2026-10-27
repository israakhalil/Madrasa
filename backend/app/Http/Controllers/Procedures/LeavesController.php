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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $items=json_decode($request->data);
        $items=collect($items);
        foreach ($items as $item) {
            $path=null;
            if($item->attached){
                $file=$item->attached;
                $substring = $this->string_between_two_string($file, '', ',');
                $replaced = Str::replace( $substring,'', $file);
                $path=request()->header('School_id'). "/leaves".'/'. now()->format('Y'). '/'.now()->format('n'). '/'.now()->format('j').'/'. $item->name ;
                Storage::disk('public')->put($path,base64_decode($replaced));
            }
            if($path){$item->attached=  $path;}

            $item->leave_date= Carbon::parse($item->leave_date);
            $item->leave_time =Carbon::parse($item->leave_time)->setTimezone('asia/jerusalem')->format('h:i:s'); 
            try {
                LeavesModel::query()->Create((array)$item);
            } catch (\Exception $exception) {
                   return response()->json([
                    'msg' => "هناك حقول يجب ادخالها",
                    'code'=>StatusCodes::GENERAL_ERROR
                   ]);            }

               }
               return response()->json(['msg' => "تمت الاضافة بنجاح", 'code'=>StatusCodes::OK ]);
    }

    public function string_between_two_string($str, $starting_word, $ending_word)
    {
        $subtring_start = strpos($str, $starting_word);
        $subtring_start += strlen($starting_word); 
        $size = strpos($str, $ending_word, $subtring_start) - $subtring_start; 
        return substr($str, $subtring_start, $size+1); 
    }

    public function save(Request  $request, $id = null)
    {
        // $data = $request->only(LeavesModel::FILLABLE);
       $filename=null; $path=null;
        if ($request->hasFile('attached')) {
            $file = $request->attached;
            $path=request()->header('School_id')
            . "/leaves"
            .'/'. now()->format('Y')
            . '/'.now()->format('n')
            . '/'.now()->format('j');
            $filename=$file->getClientOriginalName();
            $path= Storage::disk('public')->putFileAs($path,$file ,$filename);
        }
        $data =(array) json_decode($request->data);
        if($path){$data["attached"]=  @$path;}
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