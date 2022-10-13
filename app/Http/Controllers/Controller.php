<?php

namespace App\Http\Controllers;

use App\Constants\Enum;
use App\Constants\StatusCodes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function indexHome()
    {
        return view('welcome');
    }


    public function response_api($status, $code, $message_code, $data = [], $extra_data = [])
    {
         $response = array_merge([
            'status' => $status,
            'code' => $code,
            'message' => @__($message_code)['value'],
            'data' => $data,
        ], $extra_data);
        return response()->json($response, $code);
    }

    // public function notFoundResponse()
    // {
    //     return $this->response_api(false , StatusCodes::NOT_FOUND , Enum::NOT_FOUND , []);
    // }
    // public function response_api_custom_message($status, $code, $message, $data = [], $extra_data = [])
    // {
    //     $response = array_merge([
    //         'status' => $status,
    //         'code' => $code,
    //         'message' => $message,
    //         'data' => $data,
    //     ], $extra_data);
    //     return response()->json($response, $code);
    // }

    public function getPaginatorData($paginator)
    {
        return [
            'pagination' =>[
                'total' => $paginator->total(),
                'count' => $paginator->count(),
                'per_page' => $paginator->perPage(),
                'current_page' => $paginator->currentPage(),
                'total_pages' => $paginator->lastPage(),
                'next_page_url' => $paginator->nextPageUrl()
            ]
//
//            'pagination' => [
//                'total' => $paginator['total_records'],
//                'per_page' => $paginator['per_page'],
//                'current_page' => $paginator['page_number'],
//                'total_pages' => $paginator['total_pages']
//            ]
        ];
    }


    // public function clear()
    // {
    //     dump(env('TELESCOPE_PREFIX'));

    //     Artisan::call('optimize');
    //     Artisan::call('config:clear');
    //     Artisan::call('route:clear');

    //     dump(env('TELESCOPE_PREFIX'));

    // }

}