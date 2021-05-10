<?php

namespace App\Rules\employee;

use App\Models\Meeting;
use Illuminate\Contracts\Validation\Rule;

class CheckMeetingStartTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($from_time, $meeting_date, $cr_id)
    {
        $this->from_time = $from_time;
        $this->meeting_date = $meeting_date;
        $this->cr_id = $cr_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $check_meeting_start_time = Meeting::where('from_time', $this->from_time)
            ->whereDate('meeting_date', $this->meeting_date)
            ->where('conference_room_id', $this->cr_id)
            ->first();

        if ($check_meeting_start_time) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The CR is already booked. Please check the different CR';
    }
}
