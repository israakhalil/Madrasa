<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Books as BooksModel;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BooksController extends  Controller
{
    public function index(Request $request )
    {
    $items = BooksModel::query()->filter()->orderBy('id', 'asc')->get();
    $data['books']  = BookResource::collection($items);
    return response()->json([
        'data' => $data,
        'code'=>StatusCodes::OK
    ]);
    }

    // public function store(Request $request, $id = null)
    // {
    //     $items=collect($request);
    //     // foreach ($items as $item) {
    //     //      $item["received_date"]= Carbon::parse($item["received_date"]);
    //     //      BooksModel::query()->Create((array)$item);
    //     // }
    //     // return response()->json([
    //     //     'msg' => "تمت الاضافة بنجاح",
    //     //     'code'=>StatusCodes::OK
    //     // ]);
        

    //     foreach ($items as $item) {
    //         $item["received_date"]= Carbon::parse($item["received_date"]);
    //         try {
    //             BooksModel::query()->Create((array)$item);
    //         } catch (\Exception $exception) {
    //                return response()->json([
    //                 'msg' => "هناك حقول يجب ادخالها",
    //                 'code'=>StatusCodes::GENERAL_ERROR
    //                ]);            }

    //            }
    //        return response()->json([
    //            'msg' => "تمت الاضافة بنجاح",
    //            'code'=>StatusCodes::OK
    //        ]);
       

    // }

    public function store(Request $request, $id = null)
    {
        $items=json_decode($request->data);
        $items=collect($items);
        foreach ($items as $item) 
        {
            $path=null;
            if($item->attached){
                $file=$item->attached;
                $substring = $this->string_between_two_string($file, '', ',');
                $replaced = Str::replace( $substring,'', $file);
                $path=request()->header('School_id'). "/books".'/'. now()->format('Y'). '/'.now()->format('n'). '/'.now()->format('j').'/'. $item->name ;
                Storage::disk('public')->put($path,base64_decode($replaced));
            }
            if($path){$item->attached=  $path;}
            $item->received_date= Carbon::parse($item->received_date);
            try {
                BooksModel::query()->Create((array)$item);
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
            . "/books"
            .'/'. now()->format('Y')
            . '/'.now()->format('n')
            . '/'.now()->format('j');
            $filename=$file->getClientOriginalName();
            $path= Storage::disk('public')->putFileAs($path,$file ,$filename);
        }
        $data =(array) json_decode($request->data);
        if($path){$data["attached"]=  @$path;}
        $data["received_date"]= Carbon::parse($data["received_date"]);
        BooksModel::query()->updateOrCreate(['id' => $id,],$data);

        return response()->json([
            'msg' => "تم الحفظ بنجاح",
            'code'=>StatusCodes::OK
        ]); 


        // $data = $request->only(BooksModel::FILLABLE);
        // $data["received_date"]= Carbon::parse($data["received_date"]);

        // BooksModel::query()->updateOrCreate(['id' => $id,], $data);
       
        // return response()->json([
        //     'msg' => "تم الحفظ بنجاح",
        //     'code'=>StatusCodes::OK
        // ]);   
     }
     
    public function delete($id)
    {
        $item = BooksModel::query()->where('id' , '=', $id);
        $item->delete();
        return response()->json([
            'msg' => "تم الحذف بنجاح",
            'code'=>StatusCodes::OK
        ]);   
       
    }
}