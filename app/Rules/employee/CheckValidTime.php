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
    public function __construct()
    {
        //
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
        $now = Carbon::now();

        // if ($value < $now) {
        //     return false;
        // } else {
        //     return true;
        // }

        //check office start time
        // if ($value < "8:30") {
        //     return false;
        // } else {
        //     return true;
        // }

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
            'Cannot book before office time'
        ];
    }
}
