<?php

namespace App\Rules\employee;

use Illuminate\Contracts\Validation\Rule;

class CheckTimeConflicts implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $from_time;
    public $to_time;

    public function __construct($from_time, $to_time)
    {
        $this->from_time = $from_time;
        $this->to_time = $to_time;
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
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
