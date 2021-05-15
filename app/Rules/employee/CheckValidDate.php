<?php

namespace App\Rules\employee;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CheckValidDate implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        //check today's date
        $today = Carbon::now()->startOfDay();

        $input_date = Carbon::parse($value)->startOfDay();

        if ($input_date != $today) {
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
            'You cannot book a meeting other than today',
        ];
    }
}
