<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PaiementController extends Controller
{
    //configuration de l'api la notification
    public function notify (Request $request)
    {
        /* 1- Recuperation des paramètres postés sur l'url par CinetPay
         * https://docs.cinetpay.com/api/1.0-fr/checkout/notification#les-etapes-pour-configurer-lurl-de-notification
         * */
        //dd(json_encode($request->all()));
        Storage::disk('public')->put("response-".date('Y-m-d-H-i-s').".json", json_encode($request->all()));
        if (isset($request->sessionId))
        {
            if($request->responsecode == '0')
            {
                $paiement = Payment::whereToken($request->sessionId)
                ->first();
                $invoice = Invoice::find($paiement->invoice_id);
                $paiement->update([
                    'created_at' => Carbon::now(),
                    'status' => 1,
                    'content' => $request->all(),
                ]);
                $invoice->update([
                    'created_at' => Carbon::now(),
                    'state_id' => 447,
                    'user_updated' => auth()->user()->id,
                ]);
                $invoice->states()->updateExistingPivot(446, [
                    'user_updated' => auth()->user()->id,
                    'status' => null,
                ]);
                $invoice->states()->attach(447, [
                    'user_created' => auth()->user()->id,
                    'status' => 1,
                ]);

                $versement = Payment::whereToken($request->sessionId)
                ->first();
                $versement->update([
                    'created_at' => Carbon::now(),
                    'status' => 1,
                ]);
                journalisation('notify', $invoice);
                echo 'Felicitation, votre paiement a été effectué avec succès';
            }
            else
            {
                /* correct, on redirige le client vers la page souhaité */
                return back()->with('info', 'Echec, votre paiement a échoué. Veuillez réessayez');
            }
        }

    }

    public function testeur()
    {
        $versement = Payment::create([
            'invoice_id' => 4,
            'means_payment_id' => 1,
            'moyen' => 'CinetPay',
            'price_final' => 1000,
            'token' => 'test',
            'status' => 0,
            //'content' => 'test',
        ]);
        //dd($versement);
    }

    //configuration de l'api de retour
    public function return (Request $request)
    {
        /* 1- recuperation des données postées par CinetPay
         * https://docs.cinetpay.com/api/1.0-fr/checkout/retour#les-etapes-pour-configurer-lurl-de-retour */
        if (isset($request->sessionId) || isset($request->responsecode))
        {
            $paiement = Payment::whereToken($request->sessionId)
            ->first();
            $invoice = Invoice::find($paiement->invoice_id);
            if($request->responsecode == '0')
            {
                // état actuellement de la commande
                $invoice->update([
                    'state_id' => 48,
                    'user_updated' => auth()->user()->id,
                ]);
                // Historique des états de la commande dans le temps
                $invoice->states()->updateExistingPivot(447, [
                    'user_updated' => auth()->user()->id,
                    'status' => null,
                ]);
                $invoice->states()->attach(48, [
                    'user_created' => auth()->user()->id,
                    'status' => 1,
                ]);
                // Notifier le client
                /* Mail::to(auth()->user()->email)->send(new InvoiceMail($this->invoice, 'client'));
                // Notifier l'adminitrateur
                foreach ($this->setting->email as $recipient) {
                    Mail::to($recipient)->send(new InvoiceMail($invoice, 'administrateur'));
                } */
                journalisation('confirmer', $invoice);
                Cart::instance('shopping')->destroy();
                Cookie::queue(Cookie::forget('custom'));
                /* correct, on redirige le client vers la page souhaité */
                //return back()->with('info', 'Felicitation, votre paiement a été effectué avec succès');
                Alert::success('Félicitation, votre paiement a bien été receptionné', 'success')->autoClose(20000);
                return redirect()->route('checkout.congrat', $request->referenceNumber);
            }
            else
            {
                // état actuellement de la commande
                $invoice->update([
                    'state_id' => 47,
                    'payment_method_id' => null,
                    'user_updated' => auth()->user()->id,
                ]);
                // Historique des états de la commande dans le temps
                $invoice->states()->updateExistingPivot(446, [
                    'user_updated' => auth()->user()->id,
                    'status' => null,
                ]);
                $invoice->states()->attach(47, [
                    'user_created' => auth()->user()->id,
                    'status' => 1,
                ]);
                /* correct, on redirige le client vers la page souhaité */
                //return back()->with('info', 'Echec, votre paiement a échoué');
                Alert::error('Echec, votre paiement a échoué. Veuillez réessayez', 'error')->autoClose(20000);
                return redirect()->route('checkout.index');
            }
        }
        else{
            print("transaction non fourni");
        }
    }
}
