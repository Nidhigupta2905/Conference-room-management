<?php

namespace App\Http\Requests\employee;

// use App\Rules\admin\CheckMeetingEndTimeUpdate;
use App\Rules\admin\CheckMeetingStartTimeUpdate;
use App\Rules\admin\CheckMeetingUpdateTimeConflict;
use App\Rules\employee\CheckValidDate;
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

            'from_time' => [
                'required',

                'date_format:H:i',

                new CheckMeetingStartTimeUpdate($this->from_time, $this->to_time, $this->meeting_date, $this->cr_id),
            ],

            'to_time' => [
                'required',

                'date_format:H:i',

                'after:from_time',

                // new CheckMeetingEndTimeUpdate($this->from_time, $this->to_time, $this->meeting_date, $this->cr_id),

                new CheckMeetingUpdateTimeConflict($this->from_time, $this->to_time, $this->meeting_date, $this->cr_id),
            ],
        ];
    }

    public function messages(Type $var = null)
    {
        return [
            'cr_id.required' => 'The CR Name is required',
            'meeting_date.required' => 'The meeting date is required',
            'from_time.required' => 'Meeting start time is required',
            'to_time.required' => 'Meeting end time is required',
        ];

    }
}
