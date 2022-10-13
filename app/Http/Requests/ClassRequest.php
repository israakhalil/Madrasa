<?php

namespace App\Http\Requests;

use App\Constants\StatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ClassRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            // 'level_id' => 'required|numeric|max:10',
            'attached_file' => 'nullable|string|max:255',
            // 'user_id' => 'required|numeric|max:10',
        ];
    }
   
}