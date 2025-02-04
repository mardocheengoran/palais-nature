<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use App\Models\Deal;
use App\Models\Parameter;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class EcommercePaimentController extends Controller
{
    //configuration de l'api la notification
    public function notify_url (Request $request)
    {
        /* 1- Recuperation des paramètres postés sur l'url par CinetPay
         * https://docs.cinetpay.com/api/1.0-fr/checkout/notification#les-etapes-pour-configurer-lurl-de-notification
         * */
        if (isset($request->cpm_trans_id))
        {
            $payment = Payment::whereToken($request->cpm_trans_id)->first();
            $invoice = $payment->invoice;

            if ($payment) {
                // A l'aide de l'identifiant de votre transaction, vérifier que la commande n'a pas encore été traité
                $VerifyStatusCmd = "1"; // valeur du statut à récupérer dans votre base de donnée
                if ($VerifyStatusCmd == '00') {
                    //$donation->update();
                    // La commande a été déjà traité
                    // Arret du script
                    die();
                }

                /* 2- Dans le cas contraire, on vérifie l'état de la transaction en cas de tentative de paiement sur CinetPay
                * https://docs.cinetpay.com/api/1.0-fr/checkout/notification#2-verifier-letat-de-la-transaction */
                $cinetpay_check = [
                    "apikey" => env("APIKEY"),
                    "site_id" => $request->cpm_site_id,
                    "transaction_id" => $request->cpm_trans_id
                ];
                $response = $this->getPayStatus($cinetpay_check); // appel fonction de requête pour récupérer le statut

                //On recupère la réponse de CinetPay
                $response_body = json_decode($response,true);
                if($response_body['code'] == '00')
                {
                    Storage::disk('public')->put("response-".$request->cpm_trans_id.".json", json_encode($response_body));
                    $paiementArray = json_encode($response_body);
                    $user = User::find($payment->user_id);

                    $payment->update([
                        'price_discount' => $response_body['data']['amount'],
                        'after_payment' => $paiementArray,
                        'status' => 1,
                        'user_updated' => $payment->user_id,
                        //'state_id' => 1069,
                    ]);

                    $invoice->update([
                        'user_updated' => $user->id,
                        'created_at' => Carbon::now(),
                        'state_id' => 47,
                    ]);
                    $invoice->states()->attach(47, [
                        'user_created' => $user->id,
                        'status' => 1,
                    ]);
                    // Diminuer la quantité de l'article disponible
                    /* foreach (Cart::instance('shopping')->content() as $item) {
                        $article = detailPanier($item->id);
                        if ($article and $article->available_id == 1049) {
                            Deal::create([
                                'type_deal_id' => 1065,
                                'quantity' => $item->qty,
                                'price' => $article->price_new,
                                'price_total' => $article->price_new * $item->qty,
                                'article_id' => $article->id,
                                'invoice_id' => $invoice->id,
                            ]); */

                            /* $article->update([
                                'quantity' => $article->quantity - $item->qty,
                            ]); */
                        /* }
                    } */
                    // Notifier le client
                    Mail::to($user->email)->send(new InvoiceMail($invoice, 'client'));
                    // Notifier l'adminitrateur
                    foreach (setting()->email as $recipient) {
                        Mail::to($recipient)->send(new InvoiceMail($invoice, 'administrateur'));
                    }
                    journalisation('confirmer', $invoice);
                    Cart::instance('shopping')->destroy();
                    //Cookie::queue(Cookie::forget('custom'));
                    /* https://docs.cinetpay.com/api/1.0-fr/checkout/notification#3-delivrer-un-service*/
                    echo 'Felicitation, votre paiement a été effectué avec succès';
                }
                else
                {
                    // transaction a échoué
                    echo 'Echec, code:' . $response_body['code'] . ' Description' . $response_body['description'] . ' Message: ' .$response_body['message'];
                }
            }
            // Mettez à jour la transaction dans votre base de donnée
            //$donation->update();
        }
        else{
            print("cpm_trans_id non fourni");
        }
    }

    //configuration de l'api de retour pour les carte de membre
    public function return_url (Request $request, $code)
    {
        /* 1- recuperation des données postées par CinetPay
         * https://docs.cinetpay.com/api/1.0-fr/checkout/retour#les-etapes-pour-configurer-lurl-de-retour */
        if (isset($request->transaction_id) || isset($request->token))
        {
            /* 2- on vérifie l'état de la transaction sur CinetPay ou dans notre base de donnée
            * https://docs.cinetpay.com/api/1.0-fr/checkout/notification#2-verifier-letat-de-la-transaction */
            $cinetpay_check = [
                "apikey" => env("APIKEY"),
                "site_id" => env('BOUTIQUE_SITE_ID'),
                "transaction_id" => $request->transaction_id
            ];
            // appel fonction de requête pour récupérer le statut chez CinetPay
            $response = $this->getPayStatus($cinetpay_check);
            //On recupère la réponse de CinetPay
            $response_body = json_decode($response,true);
            if($response_body['code'] == '00')
            {
                /* correct, on redirige le client vers la page souhaité */
                toast('Commande validée avec succès', 'warning')->autoClose(15000);
                return redirect()->route('checkout.congrat', $code);
            }
            else
            {
                toast('Paiement annulé', 'warning')->autoClose(15000);
                return redirect()->route('checkout.index');
            }
        }
        else{
            toast('Paiement annulé', 'warning')->autoClose(15000);
            return redirect()->route('checkout.index');
            //print("transaction non fourni");
        }
    }
}
