<?php

namespace App\Http\Requests\admin\meeting;

use App\Rules\employee\CheckValidDate;
use App\Rules\employee\CheckValidTime;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFormRequest extends FormRequest
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
            'cr_id' => 'required',

            'meeting_date' => ['required', 'date_format:Y-m-d', new CheckValidDate],

            'from_time' => ['required', 'date_format:h:i A', new CheckValidTime($this->from_time)],

            'to_time' => ['required', 'date_format:h:i A', 'after:from_time'],
        ];
    }

    public function messages()
    {
        return [
            'cr_id.required' => 'The CR Name is required',
            'meeting_date.required' => 'The meeting date is required',
            'from_time.required' => 'Meeting start time is required',
            'to_time.required' => 'Meeting end time is required',
        ];

    }
}
