<?php
namespace App\Http\Controllers\School;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\School\classes as ClassesModel;
// use App\Http\Requests\ClassRequest;
use App\Http\Resources\ClassResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassesController extends  Controller
{

    public function index(Request $request )
    {
         
        $items = ClassesModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['Classes']  = ClassResource::collection($items);
        return response()->json([
            'data' => $data,
            'code'=>StatusCodes::OK
        ]);
    }


    public function store(Request $request, $id = null)
    {
       
            $file = $request->file_name;    
            $filename=$file->store("Files");

            $data = json_decode($request->data);
            $_class=new ClassesModel();
            $_class->name=$data->name;
            $_class->level_id= $data->level_id;
            $_class->attached_file=$filename;
            $_class->user_id=1;
            $_class->school_id=1;
            $_class->save();

           return response()->json([
            'data' => $_class,
            'code'=>StatusCodes::CREATED
        ]);
        
    }
}