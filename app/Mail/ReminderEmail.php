<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReminderEmail extends Mailable 
{
    use Queueable, SerializesModels;

    public $record;
    public $type;

    public function __construct($record, $type)
    {
        $this->record = $record;
        $this->type = $type;
    }

    public function build()
    {
        $subject = $this->type === 'medical' ? 'Medical Treatment Reminder' : 'Vaccination Reminder';

        return $this->subject($subject)
                    ->view('emails.reminder')
                    ->with([
                        'type' => $this->type,
                        'record' => $this->record,
                    ]);
    }
}
