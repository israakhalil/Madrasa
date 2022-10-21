<?php
namespace App\Http\Controllers\Constants;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConstantResource;
use App\Models\Constants\AbsenceTypes as AbsenceTypesModel;
use App\Models\Constants\ViolationDegrees as ViolationDegreesModel;
use App\Models\Constants\ViolationProcedures as ViolationProceduresModel;
use Illuminate\Http\Request;

class ConstantsController extends  Controller
{
    public function absenceTypes(Request $request )
    {
        
        $items = AbsenceTypesModel::query()->orderBy('id', 'asc')->get();
        $data['absenceTypes']  = ConstantResource::collection($items);

        return response()->json([
            'status' => true,
        'data' => $data,
        'code'=>StatusCodes::OK]
    );
    }
    public function violationDegrees(Request $request )
    {
        
        $items = ViolationDegreesModel::query()->orderBy('id', 'asc')->get();
        $data['violationDegrees']  = ConstantResource::collection($items);

        return response()->json([
            'status' => true,
        'data' => $data,
        'code'=>StatusCodes::OK]
    );
    }

    public function violationProcedures(Request $request )
    {
        
        $items = ViolationProceduresModel::query()->orderBy('id', 'asc')->get();
        $data['violationProcedures']  = ConstantResource::collection($items);

        return response()->json([
            'status' => true,
        'data' => $data,
        'code'=>StatusCodes::OK]
    );
    }

}