<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Violations as ViolationsModel;
use App\Http\Resources\ViolationResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ViolationsController extends  Controller
{

    public function index(Request $request )
    {
        $items = ViolationsModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['violations']  = ViolationResource::collection($items);
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
        
            $path=null; $path2=null;
            if($item->attached){
                $file=$item->attached;
                $substring = $this->string_between_two_string($file, '', ',');
                $replaced = Str::replace( $substring,'', $file);
                $path=request()->header('School_id'). "/violations".'/'. now()->format('Y'). '/'.now()->format('n'). '/'.now()->format('j').'/'. $item->name ;
                Storage::disk('public')->put($path,base64_decode($replaced));
            }
            if($item->audio){
                $audio=$item->audio;
                $substring = $this->string_between_two_string($audio, '', ',');
                $replaced = Str::replace( $substring,'', $audio);
                $path2=request()->header('School_id'). "/violations".'/'. now()->format('Y'). '/'.now()->format('n'). '/'.now()->format('j').'/'. $item->audioname ;
                Storage::disk('public')->put($path2,base64_decode($replaced));
            }

            if($path){$item->attached=  $path;}
            if($path2){$item->audio=  $path2;}
            $item->violation_date= Carbon::parse($item->violation_date);
            try {
                ViolationsModel::query()->Create((array)$item);

            } catch (\Exception $exception) {
                   return response()->json([
                    'msg' => "هناك حقول يجب ادخالها",
                    'code'=>StatusCodes::GENERAL_ERROR
                   ]);         
                   }

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
        // $data = $request->only(ViolationsModel::FILLABLE);
        $filename=null; $path=null;$path_audio=null;
        if ($request->hasFile('attached')) {
            $file = $request->attached;
            $path=request()->header('School_id')
            . "/violations"
            .'/'. now()->format('Y')
            . '/'.now()->format('n')
            . '/'.now()->format('j');
            $filename=$file->getClientOriginalName();
            $path=Storage::disk('public')->putFileAs($path,$file ,$filename);
        }
        if ($request->hasFile('audio')) {
            $file = $request->audio;
            $path_audio=request()->header('School_id')
            . "/violations/audio"
            .'/'. now()->format('Y')
            . '/'.now()->format('n')
            . '/'.now()->format('j');
            $filename=$file->getClientOriginalName();
            
            $path_audio=Storage::disk('public')->putFileAs($path_audio,$file ,$filename);

        }

        $data =(array) json_decode($request->data);
        if($path){$data["attached"]=  @$path;}
        if($path_audio){$data["audio"]=  $path_audio;}
        $data["violation_date"]= Carbon::parse($data["violation_date"]);

        ViolationsModel::query()->updateOrCreate(['id' => $id,], $data);
       
        return response()->json([
            'msg' => "تم الحفظ بنجاح",
            'code'=>StatusCodes::OK
        ]);   
     }

    public function delete($id)
    {
        $item = ViolationsModel::query()->where('id' , '=', $id);
        $item->delete();
        return response()->json([
            'msg' => "تم الحذف بنجاح",
            'code'=>StatusCodes::OK
        ]);   
       
    }
}