<?php

namespace App\Rules\admin;

use App\Models\Meeting;
use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class CheckMeetingUpdateTimeConflict implements Rule
{
    
    private $from_time, $to_time, $meeting_date, $cr_id, $meeting_id;
    
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
        $start_time = Carbon::parse($this->from_time, 'Asia/Kolkata')->format("H:i");
        $end_time = Carbon::parse($this->to_time, 'Asia/Kolkata')->format("H:i");

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
            })->where('id', '!=', $this->meeting_id)->exists();

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
