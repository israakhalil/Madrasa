<?php
namespace App\Http\Controllers\School;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;

use App\Models\School\Levels as LevelsModel;
use App\Models\School\Classes as ClassesModel;
use App\Models\School\Schools as SchoolsModel;
use App\Http\Resources\LevelResource;
use App\Http\Resources\SchoolResource;
use App\Http\Resources\ClassResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolsController extends  Controller
{
    public function schools()
    {
        $items = SchoolsModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['Schools']  = SchoolResource::collection($items);
        return response()->json([
            'data' => $data,
            'code'=>StatusCodes::OK
        ]);
    }

    public function index(Request $request )
    {

        // $data['department_id'] = request()->header('Center-Id');
        $request['school_id']= request()->header('School_id');
        $item = SchoolsModel::query()->filter()->orderBy('id', 'asc')->first();
        $data['School']=new SchoolResource($item);

        $items = LevelsModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['Levels'] = LevelResource::collection($items);

        $items = ClassesModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['Classes']  = ClassResource::collection($items);

        //  return response()->json($data, StatusCodes::OK);
         return response()->json([
            'status' => true,
            'data' => $data,
            'code'=>StatusCodes::OK
        ]);
        // return $this->response_api(true, StatusCodes::OK, $data);
    }


public function store(Request $request, $id = null)
{
    $filename=null;
        if ($request->hasFile('logo')) {
            $file = $request->logo;
             $filename=$file->store("images");
            //  $filename=$file->store("public/images");
        }
         $ret = str_replace('public/','',$filename);
        $data = json_decode($request->data);
        $student=new SchoolsModel();
        if($id){
            $item = SchoolsModel::where('id', $id)->first();
            // return  $item ;
            if($item->logo==$data->logo){
                $data=$student::where('id', $id)->update(['name' => $data->name]);

            }else{
                $data=$student::where('id', $id)->update(['name' => $data->name,'logo'=>$filename]);

            }
            return response()->json([
                'status' => true,
                'data' => $data,
                'code'=>StatusCodes::OK
            ]);
        }
        else{
            $student->name=$data->name;
            $student->logo=$filename ;
            $student->save();
        }

}

public function delete($id)
{
    $item = SchoolsModel::query()->where('id' , '=', $id);
    $item->delete();
    return response()->json([
        'msg' => "تم الحذف بنجاح",
        'code'=>StatusCodes::OK
    ]);

}
}
