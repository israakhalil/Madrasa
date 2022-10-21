<?php
namespace App\Http\Controllers\Procedures;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Procedures\Books as BooksModel;
use Illuminate\Http\Request;
use Carbon\Carbon;


class BooksController extends  Controller
{

    public function store(Request $request, $id = null)
    {
        $items=collect($request);
        foreach ($items as $item) {
             $item["received_date"]= Carbon::parse($item["received_date"]);
             BooksModel::query()->Create((array)$item);
        }
        return response()->json([
            'msg' => "تمت الاضافة بنجاح",
            'code'=>StatusCodes::OK
        ]);
        
    }
}