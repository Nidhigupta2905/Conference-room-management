<?php

namespace App\Rules\employee;

use App\Models\Meeting;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class CheckMeetingTimeConflicts implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($from_time, $to_time, $meeting_date, $cr_id)
    {
        $this->from_time = $from_time;
        $this->to_time = $to_time;
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
        $start_time = Carbon::parse($this->from_time, 'Asia/Kolkata')->format("H:i");
        $end_time = Carbon::parse($this->to_time, 'Asia/Kolkata')->format("H:i");

        // $from_time = $this->from_time;
        // $to_time = $this->to_time;

        $check_start_time_conflict = Meeting::whereDate('meeting_date', $this->meeting_date)
            ->where('conference_room_id', $this->cr_id)
            ->where(function ($query) use ($start_time, $end_time) {
                $query->orWhere('from_time', $start_time)
                    ->orWhere('to_time', $end_time)
                    ->orWhere(function ($query) use ($start_time, $end_time) {

                        //if meeting start time occurs between an existing meeting
                        $query->where('from_time', '<', $start_time)
                            ->where('to_time', '>', $start_time);
                    })

                    ->orWhere(function ($query) use ($start_time, $end_time) {

                        //if meeting end time occurs between the existing meeting
                        $query->where('from_time', '<', $end_time)
                            ->where('to_time', '>', $end_time);
                    })
                    ->orWhere(function ($query) use ($start_time, $end_time) {

                        //if existing meeting occurs between this meeting time
                        $query->where('from_time', '>', $start_time)
                            ->where('to_time', '<', $end_time);
                    });
            })->exists();

        if ($check_start_time_conflict) {
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
        return 'Choose a different meeting start or end time';
    }
}
