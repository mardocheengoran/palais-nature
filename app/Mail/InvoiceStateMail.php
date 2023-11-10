<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Detection\MobileDetect;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceStateMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice, $role;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $role)
    {
        $this->invoice = $invoice;
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->subject('Votre commande Bezo '.$this->invoice->code)
        ->view('email.state')->with([
            'invoice' => $this->invoice,
            'role' => $this->role,
            'title' => 'Bezo',
        ]);
    }
}
