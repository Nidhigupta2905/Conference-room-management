<?php

namespace App\Rules\admin;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Meeting;

class CheckMeetingStartTimeUpdate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($from_time, $to_time, $meeting_date, $cr_id, $meeting_id)
    {
        $this->from_time = $from_time;
        $this->to_time = $to_time;
        $this->meeting_date = $meeting_date;
        $this->cr_id = $cr_id;
        $this->meeting_id = $meeting_id;
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
            ->where('to_time', $this->to_time)
            ->whereDate('meeting_date', $this->meeting_date)
            ->where('conference_room_id', $this->cr_id)
            ->where('id', '!=', $this->meeting_id)
            ->exists();

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
        return 'Booked Already for the time. Choose another CR';
    }
}
