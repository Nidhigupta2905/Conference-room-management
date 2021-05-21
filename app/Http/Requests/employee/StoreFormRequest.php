<?php

namespace App\Http\Requests\employee;

use App\Rules\employee\CheckMeetingStartTime;
use App\Rules\employee\CheckMeetingTimeConflicts;
use App\Rules\employee\CheckValidDate;
use Carbon\Carbon;
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
            'cr_id' => 'required',

            'meeting_date' => ['required', 'date_format:Y-m-d', new CheckValidDate],

            'from_time' => ['required', 'date_format:H:i', new CheckMeetingStartTime($this->from_time, $this->meeting_date, $this->cr_id)],

            'to_time' => ['required', 'date_format:H:i', 'after:from_time', new CheckMeetingTimeConflicts($this->from_time, $this->to_time, $this->meeting_date, $this->cr_id)],

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


    public function getData()
    {

        $start_time = Carbon::parse($this->from_time, 'Asia/Kolkata')->format("H:i:s");
        $end_time = Carbon::parse($this->to_time, 'Asia/Kolkata')->format("H:i:s");

        // dd($start_time);
        return [
            'conference_room_id' => $this->cr_id,
            'meeting_date' => $this->meeting_date,
            'from_time' => $start_time,
            'to_time' => $end_time,
            'user_id' => $this->user()->id,
        ];
    }
}
