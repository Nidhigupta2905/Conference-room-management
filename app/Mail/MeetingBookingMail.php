<?php

namespace App\Mail;

use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingBookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $meetingDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($meetingDetails)
    {
        $this->meetingDetails = $meetingDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("CR Management System")
            ->markdown('employee.mail.email');
    }
}
