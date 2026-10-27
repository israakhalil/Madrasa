<?php
namespace App\Http\Controllers\School;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Models\School\Levels as LevelsModel;
use Illuminate\Http\Request;

class LevelsController extends  Controller
{
    public function index(Request $request )
    {
         $request['school_id']= request()->header('School_id');

        $items = LevelsModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['Levels']  = LevelResource::collection($items);

        return response()->json([
        'status' => true,
        'data' => $data,
        'code'=>StatusCodes::OK]
    );
    }
    public function levelGroup(Request $request )
    {
        $request['school_id']= request()->header('School_id');

        $items = LevelsModel::query()->filter()->orderBy('id', 'asc')->get();
        $data['Classes']  = LevelResource::collection($items)->map->groupClasses($request);

        return response()->json([
                'data' => $data,
                'code'=>StatusCodes::OK]
        );
    }

    public function store(Request  $request, $id = null)
    {
        $data = $request->only(LevelsModel::FILLABLE);
        $data['school_id']= request()->header('School_id');
        LevelsModel::query()->updateOrCreate(['id' => $id,], $data);

        return response()->json([
            'msg' => "تم الحفظ بنجاح",
            'code'=>StatusCodes::OK
        ]);
    }
    public function delete($id)
    {
        $item = LevelsModel::query()->where('id' , '=', $id);
        $item->delete();
        return response()->json([
            'msg' => "تم الحذف بنجاح",
            'code'=>StatusCodes::OK
        ]);

    }


}
