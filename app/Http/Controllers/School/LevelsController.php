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



}