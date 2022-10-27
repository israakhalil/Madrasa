<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Books as BooksModel;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;
use Carbon\Carbon;


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

    public function store(Request $request, $id = null)
    {
        $items=collect($request);
        // foreach ($items as $item) {
        //      $item["received_date"]= Carbon::parse($item["received_date"]);
        //      BooksModel::query()->Create((array)$item);
        // }
        // return response()->json([
        //     'msg' => "تمت الاضافة بنجاح",
        //     'code'=>StatusCodes::OK
        // ]);
        

        foreach ($items as $item) {
            $item["received_date"]= Carbon::parse($item["received_date"]);
            try {
                BooksModel::query()->Create((array)$item);
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
        $data = $request->only(BooksModel::FILLABLE);
        $data["received_date"]= Carbon::parse($data["received_date"]);

        BooksModel::query()->updateOrCreate(['id' => $id,], $data);
       
        return response()->json([
            'msg' => "تم الحفظ بنجاح",
            'code'=>StatusCodes::OK
        ]);   
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