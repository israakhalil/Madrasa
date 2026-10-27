<?php

namespace App\Http\Requests;

use App\Constants\StatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $password_validation = $this->isMethod('PUT') ? 'nullable|min:8|confirmed' : 'required|min:8|confirmed';
        $id = $this->route('id');

        return [
            'username' => 'required|string|max:255|unique:users,username,'.$id,
            'id_number' => 'required|string|max:255|unique:users,id_number,'.$id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,'.$id,
            'password' => $password_validation,
//            'roles' => 'required|array',
//            'roles.*' => 'required|numeric',
//
//            'permissions' => 'array',
//            'permissions.*' => 'required|numeric'


        ];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'code' => StatusCodes::VALIDATION_ERROR,
            'message' => $validator->errors()->first(),
            'data' => [],
        ], StatusCodes::VALIDATION_ERROR));
    }


    public function attributes()
    {
        return [
            'username' => __('attributes.username'),
            'id_number' => __('attributes.id_number'),
            'name' => __('attributes.name'),
            'email' => __('attributes.email'),
            'password' => __('attributes.password'),
//            'password_confirmation' => __('attributes.password_confirmation'),
//            'roles' => __('attributes.roles'),
//            'roles.*' => __('attributes.role'),
            'departments' => __('attributes.departments'),
            'departments.*' => __('attributes.departments'),
//            'permissions' => __('attributes.permissions'),
//            'permissions.*' => __('attributes.permission'),

            'department_id' => __('attributes.department'),
        ];
    }
}
