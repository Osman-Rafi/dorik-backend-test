<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeacherCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $details;
    public $password;

    public function __construct($details,$password)
    {
        $this->details = $details;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Virtual Class Teacher Created')
            ->from('example@example.com')
            ->view('emails.teacher-created');
    }
}
