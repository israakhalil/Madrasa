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

        return response()->json(['status' => true,'data' => $data, 'code'=>StatusCodes::OK]);
    }

    public function storeAbsence(Request  $request, $id = null)
    {
        $data = $request->only(AbsenceTypesModel::FILLABLE);
        AbsenceTypesModel::query()->updateOrCreate(['id' => $id,], $data);

        return response()->json(['msg' => "تم الحفظ بنجاح",'code'=>StatusCodes::OK]);
    }
    public function deleteAbsence($id)
    {
        $item = AbsenceTypesModel::query()->where('id' , '=', $id);
        $item->delete();
        return response()->json(['msg' => "تم الحذف بنجاح",'code'=>StatusCodes::OK]);
    }

    /* Violation Constants */
    public function violationDegrees(Request $request )
    {
        $items = ViolationDegreesModel::query()->orderBy('id', 'asc')->get();
        $data['violationDegrees']  = ConstantResource::collection($items);
        return response()->json(['status' => true,'data' => $data, 'code'=>StatusCodes::OK]);
    }
    public function storeDegrees(Request  $request, $id = null)
    {
        $data = $request->only(ViolationDegreesModel::FILLABLE);
        ViolationDegreesModel::query()->updateOrCreate(['id' => $id,], $data);

        return response()->json(['msg' => "تم الحفظ بنجاح",'code'=>StatusCodes::OK]);
    }
    public function deleteDegrees($id)
    {
        $item = ViolationDegreesModel::query()->where('id' , '=', $id);
        $item->delete();
        return response()->json(['msg' => "تم الحذف بنجاح",'code'=>StatusCodes::OK]);
    }



    public function violationProcedures(Request $request )
    {
        
        $items = ViolationProceduresModel::query()->orderBy('id', 'asc')->get();
        $data['violationProcedures']  = ConstantResource::collection($items);

        return response()->json(['status' => true,'data' => $data, 'code'=>StatusCodes::OK]);

    }
    public function storeProcedures(Request  $request, $id = null)
    {
        $data = $request->only(ViolationProceduresModel::FILLABLE);
        ViolationProceduresModel::query()->updateOrCreate(['id' => $id,], $data);

        return response()->json(['msg' => "تم الحفظ بنجاح",'code'=>StatusCodes::OK]);
    }
    public function deleteProcedures($id)
    {
        $item = ViolationProceduresModel::query()->where('id' , '=', $id);
        $item->delete();
        return response()->json(['msg' => "تم الحذف بنجاح",'code'=>StatusCodes::OK]);
    }
}