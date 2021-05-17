<?php

namespace App\Http\Requests\admin\employee;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreFormRequest extends FormRequest
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
        return [
            'employee_name' => ['required', 'max:255', 'regex:/^[a-zA-z]/u'],
            'employee_email' => ['required', 'unique:users,email'],
        ];
    }

    public function messages()
    {
        return [
            'employee_name.required' => 'Employee name is required',
            'employee_name.max' => 'Employee Name should be max 255 characters',
            'employee_name.regex' => 'Only letters allowed in employee name',

            'employee_email.required' => 'Employee email is required',
            'employee_email.unique' => 'Email should be unique',
        ];
    }

    public function getData()
    {
        return [
            'name' => $this->employee_name,
            'email' => $this->employee_email,
            'role_id' => User::ROLES['EMPLOYEE'],
        ];
    }

}
