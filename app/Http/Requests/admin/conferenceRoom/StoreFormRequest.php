<?php

namespace App\Http\Requests\admin\conferenceRoom;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'conference_room_name' => [
                'required', 'max:15','min:3', 'regex:/^[a-zA-z]/u',
                'unique:conference_rooms,name',
            ],
        ];
    }
    public function messages()
    {
        return [
            'conference_room_name.required' => 'Conference Room name is required',
            'conference_room_name.max' => 'Should be less than 15 characters',
            'conference_room_name.min'=>'Min 3 characters required',
            'conference_room_name.regex' => 'Should be a string only',
            'conference_room_name.unique' => 'Name should be unique',

        ];
    }

    public function getData()
    {
        return [
            'name' => $this->conference_room_name
        ];
    }
}
