<?php

namespace App\Rules\employee;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckValidTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($from_time)
    {
        $this->from_time = $from_time;

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
        //check if input date is less than current date
        $now = Carbon::now('Asia/Kolkata')->format('H:i');
        
        if ($this->from_time < $now) {
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
        return [
            'The meeting start time have passed',
        ];
    }
}
