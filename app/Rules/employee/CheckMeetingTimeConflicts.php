<?php

namespace App\Rules\employee;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Meeting;

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
        $from_time = $this->from_time;
        $to_time = $this->to_time;

        $check_start_time_conflict = Meeting::whereDate('meeting_date', $this->meeting_date)
            ->where('conference_room_id', $this->cr_id)
            ->where(function ($query) use ($from_time, $to_time) {
                $query->where('from_time', $from_time)
                    ->orWhere(function ($query) use ($from_time, $to_time) {
                        $query->where('from_time', '<', $from_time)
                            ->where('to_time', '>', $from_time);
                    })
                    ->where('to_time', $this->to_time)
                    ->orWhere(function ($query) use ($from_time, $to_time) {
                        $query->where('from_time', '<', $to_time)
                            ->where('to_time', '>', $to_time);
                    })
                    ->orWhere(function ($query) use ($from_time, $to_time) {
                        $query->where('from_time', '>', $from_time)
                            ->where('to_time', '<', $to_time);
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
