<?php
namespace App\Http\Controllers\School;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use App\Http\Controllers\Controller;

use App\Models\School\Levels as LevelsModel;
use App\Models\School\classes as ClassesModel;
use App\Models\School\Schools as SchoolsModel;
use App\Http\Resources\LevelResource;
use App\Http\Resources\SchoolResource;
use App\Http\Resources\ClassResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchoolsController extends  Controller
{
    // public function index()
    // {
    //     $items = SchoolModel::query()->orderBy('id', 'desc')->paginate(\request('page_size', 10));
    //     $resource = SchoolResource::collection($items);
    //     return $this->response_api(true, StatusCodes::OK, Enum::DONE_SUCCESSFULLY, $resource, $this->getPaginatorData($items));
    // }

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

//     public function create($id = null)
//     {
//         $data = [];
//         if (isset($id)) {

//             $item = LookUpFinancialGroupsModel::where('seq' , '=', $id)->first();
//             if (!$item) {
//                 return $this->notFoundResponse();
//             }
//             $data['item'] = (new LookupFinancialGroupResource($item));

//         }

//         return $this->response_api(true, StatusCodes::OK, Enum::DONE_SUCCESSFULLY, $data);
//     }


//     public function store(FinancialGroupRequest  $request, $id = null)
//     {
//         $data = $request->only(LookUpFinancialGroupsModel::FILLABLE);
//         if (is_null($id)) {
//             $data['created_by'] = $request->user()->id;
//             $grp_cd=LookUpFinancialGroupsModel::query()->max('grp_cd');
//             $data['grp_cd']= $grp_cd+1;
//         } else {
//             $data['updated_by'] = $request->user()->id;
//         }


// //        LookUpFinancialGroupsModel::query()->updateOrCreate([
// //            'seq' => $id,
// //        ], $data);

//         DB::beginTransaction();
//         try {
//             LookUpFinancialGroupsModel::query()->updateOrCreate([
//                 'seq' => $id,
//             ], $data);

//         } catch (\Exception $exception) {
//             DB::rollBack();
//             return $this->response_api(false, StatusCodes::INTERNAL_ERROR, Enum::GENERAL_ERROR);
//         } catch (\Error $exception) {
//             DB::rollBack();
//             return $this->response_api(false, StatusCodes::INTERNAL_ERROR, Enum::GENERAL_ERROR);
//         }
//         DB::commit();
//         return $this->response_api(true, StatusCodes::OK, Enum::CREATED_SUCCESSFULLY);
//     }

//     public function delete($id)
//     {
//         $item = LookUpFinancialGroupsModel::query()->where('seq' , '=', $id);
//         if (!$item) {
//             return $this->notFoundResponse();
//         }

//         $item->delete();
//         return $this->response_api(true, StatusCodes::OK, Enum::DELETED_SUCCESSFULLY, []);
//     }

}