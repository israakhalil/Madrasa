<?php
namespace App\Http\Controllers\School;

use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\School\Classes as ClassesModel;
use App\Http\Resources\ClassResource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

// use Maatwebsite\Excel\Excel;

use App\Imports\StudentClassesImport;


class ClassesController extends  Controller
{

    public function index(Request $request )
    {
        $request['school_id']= request()->header('School_id');
        $items = ClassesModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['Classes']  = ClassResource::collection($items);
        return response()->json([
            'data' => $data,
            'code'=>StatusCodes::OK
        ]);
    }


    public function store(Request $request, $id = null)
    {
        $filename=null;
       
        if ($request->hasFile('file_name')) {
            $file = $request->file_name;   
            $filename=$file->store("Files");
        }
        
            $data = json_decode($request->data);
            $_class=new ClassesModel();
            $_class->name=$data->name;
            $_class->level_id= $data->level_id;
            $_class->attached_file=$filename;
            $_class->user_id=$request->user()->id;
            $_class->school_id=request()->header('School_id');
            $_class->save();

      
        
    }

    public function import(Request $request)
    {
        if ($request->hasFile('file_name'))
         {
            $file = $request->file('file_name');
            if ($file->isValid()) 
            {
                $path = $file->getRealPath();
                $classId=$request->class_id;
                Excel::import(new StudentClassesImport((int)$classId), $path);
                return response()->json([
                  
                    'code'=>StatusCodes::OK
                ]);          
              }
         }
    }


    // public function import(Request $request)
    // {
    //     if ($request->hasFile('file_name')) {
    //         $file = $request->file('file_name');
    //         if ($file->isValid()) {
    //             $path = $file->getRealPath();
    //             Excel::import(new StudentClassesImport(), $path);
    //             return $this->response_api(true, StatusCodes::OK, Enum::DONE_SUCCESSFULLY, []);
    //         }
    //         return $this->response_api(false, StatusCodes::UPLOAD_ERR, Enum::UPLOAD_ERR_NOT_VALID, []);

    //     }
    //     return $this->response_api(false, StatusCodes::UPLOAD_ERR, Enum::UPLOAD_ERR_NO_FILE, []);
    // }

}