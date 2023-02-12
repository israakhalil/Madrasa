<?php
namespace App\Http\Controllers\Procedures;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Absences as AbsencesModel;
use App\Http\Resources\AbsenceResource;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $items=json_decode($request->data);
        $items=collect($items);
        return $items;
        foreach ($items as $item) 
        {
            $path=null;
            if($item->attached){
                $file=$item->attached;
                $substring = $this->string_between_two_string($file, '', ',');
                $replaced = Str::replace( $substring,'', $file);
                $path=request()->header('School_id'). "/absences".'/'. now()->format('Y'). '/'.now()->format('n'). '/'.now()->format('j').'/'. $item->name ;
                Storage::disk('public')->put($path,base64_decode($replaced));
            }
            if($path){$item->attached=  $path;}
            $item->absence_date= Carbon::parse($item->absence_date);
            try {
                 AbsencesModel::query()->Create((array)$item);
               } 
            catch (\Exception $exception) {
               return response()->json([
                   'msg' => "هناك حقول يجب ادخالها",
                   'code'=>StatusCodes::GENERAL_ERROR
               ]);  
              }
         }
         return response()->json([ 'msg' => "تمت الاضافة بنجاح",'code'=>StatusCodes::OK ]);
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