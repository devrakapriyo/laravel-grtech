<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $subjek;
    protected $messages;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subjek, $messages)
    {
        $this->subjek = $subjek;
        $this->messages = $messages;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('maildev.raka@gmail.com')
            ->subject($this->subjek)
            ->view('notification.mail')
            ->with([
                    'subject'=>$this->subjek,
                    'messages'=>$this->messages
            ]);
    }
}
