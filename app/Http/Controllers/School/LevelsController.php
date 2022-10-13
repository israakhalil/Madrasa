<?php
namespace App\Http\Controllers\School;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Resources\LevelResource;
use App\Models\School\Levels as LevelsModel;
use App\Models\School\classes as ClassesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelsController extends  Controller
{
    public function index(Request $request )
    {
         $request['school_id']=1;
        
        $items = LevelsModel::query()->filter()->orderBy('id', 'asc')->get();
        $resource = LevelResource::collection($items);

        return response()->json($resource, 200);
    }



}