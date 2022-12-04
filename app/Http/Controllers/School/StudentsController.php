<?php
namespace App\Http\Controllers\School;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\School\Students as StudentsModel;
use App\Http\Resources\StudentResource;
use App\Imports\StudentDetails;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class StudentsController extends  Controller
{

    public function index(Request $request )
    {
        $items = StudentsModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['Students']  = StudentResource::collection($items);
        return response()->json([
            'data' => $data,
            'code'=>StatusCodes::OK
        ]);
    }

    // public function store2(Request $request, $id = null)
    // {
    //     $filename=null;
       
    //     if ($request->hasFile('file_name')) {
    //         $file = $request->file_name;   
    //         $filename=$file->store("Files");
    //     }
          
    //         $data = json_decode($request->data);
    //         $student=new StudentsModel();
    //         $student->name=$data->name;
    //         $student->class_id= $data->class_id;
    //         $student->date_of_birth=Carbon::parse('12/02/2022');
    //         $student->attached_id=$filename;
    //         $student->save();
    // }
    public function store(Request $request, $id = null)
    {
        $filename=null;
        $data = json_decode($request->data);
        $name=$data->name;
        $classId= $data->class_id;

        if ($request->hasFile('file_name'))
        {
           $file = $request->file('file_name');
           if ($file->isValid())
           {
               $path = $file->getRealPath();
               Excel::import(new StudentDetails((int)$classId,(string)$name), $path);
               return response()->json([

                   'code'=>StatusCodes::OK
               ]);
             }
        }else{
            $data = json_decode($request->data);
            $student=new StudentsModel();
            $student->name=$name;
            $student->class_id= $classId;
            $student->save();
        }
          


      
        
    }


    // public function import(Request $request)
    // {
    //     if ($request->hasFile('file_name'))
    //      {
    //         $file = $request->file('file_name');
    //         if ($file->isValid())
    //         {
    //             $path = $file->getRealPath();
    //             $classId=$request->class_id;
    //             Excel::import(new StudentClassesImport((int)$classId), $path);
    //             return response()->json([

    //                 'code'=>StatusCodes::OK
    //             ]);
    //           }
    //      }
    // }

    public function edit(Request  $request, $id = null)
    {
        $data = $request->only(StudentsModel::FILLABLE);
        $data["date_of_birth"]= Carbon::parse($data["date_of_birth"]);

        StudentsModel::query()->updateOrCreate(['id' => $id,], $data);
       
        return response()->json([
            'msg' => "تم الحفظ بنجاح",
            'code'=>StatusCodes::OK
        ]);   
     }


     public function delete($id)
     {
         $item = StudentsModel::query()->where('id' , '=', $id);
         $item->delete();
         return response()->json([
             'msg' => "تم الحذف بنجاح",
             'code'=>StatusCodes::OK
         ]);
 
     }
}