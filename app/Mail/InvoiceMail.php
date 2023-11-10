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

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice;
    public $type;
    public $setting;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice, $type)
    {
        $this->invoice = $invoice;
        $this->type = $type;
        $this->setting = setting();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->type == 'administrateur') {
            $subject = 'Nouvelle commande ('.$this->invoice->code.') sur '.$this->setting->title;
        }
        elseif($this->type == 'client') {
            $subject = 'Votre commande '.$this->invoice->code.' a été confirmée';
        }
        elseif($this->type == 'fournisseur') {
            $subject = 'Nouvelle commande ('.$this->invoice->code.') sur '.$this->setting->title;
        }
        return $this
        ->subject($subject)
        ->view('email.invoice')->with([
            'invoice' => $this->invoice,
            'type' => $this->type,
            'setting' => $this->setting,
        ]);
    }
}
