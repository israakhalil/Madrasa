<?php
namespace App\Http\Controllers\School;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Models\School\Students as StudentsModel;
use App\Http\Resources\StudentResource;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function store2(Request $request, $id = null)
    {
        $filename=null;
       
        if ($request->hasFile('file_name')) {
            $file = $request->file_name;   
            $filename=$file->store("Files");
        }
          
            $data = json_decode($request->data);
            $student=new StudentsModel();
            $student->name=$data->name;
            $student->class_id= $data->class_id;
            $student->date_of_birth=Carbon::parse('12/02/2022');
            $student->attached_id=$filename;
            $student->save();
    }
    public function store(Request $request, $id = null)
    {
        $filename=null;
       
        if ($request->hasFile('file_name')) {
            $file = $request->file_name;   
            $filename=$file->store("Files");
        }
          
            $data = json_decode($request->data);
            return $data;
            $student=new StudentsModel();
            $student->name=$data->name;
            $student->class_id= $data->class_id;
            $student->date_of_birth=Carbon::parse('12/02/2022');
            $student->attached_id=$filename;
            $student->save();

      
        
    }
}