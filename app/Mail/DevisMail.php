<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DevisMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $contact, $setting;

    public function __construct($contact, $setting)
    {
        //
        $this->contact = $contact;
        $this->setting = $setting;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Vous avez un nouveau message')
            ->markdown('email.contact');

        return $this
        ->subject($this->setting->title.' - Vous avez un nouveau message')
        ->view('email.contact');
    }
}
