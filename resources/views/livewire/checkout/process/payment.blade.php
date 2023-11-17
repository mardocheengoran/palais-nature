<div class="card shadow mb-3">
    <div class="card-header">
        <div class="position-absolute end-0">
            @if ($invoice->payment_method_id)
                <button wire:loading.attr="disabled" type="button" class="text-warning btn btn-sm" wire:click='paymentDelete'>
                    <i class="icofont-pencil"></i>
                    Modifier
                    <div wire:loading wire:target='paymentDelete'>
                        <span class="spinner-border spinner-border-sm"></span>
                    </div>
                </button>
            @endif
        </div>
        <i class="icofont-check-circled {{ $invoice->payment_method_id ? 'bg-success text-white rounded-circle' : '' }}"></i>
        3. Mode de paiement
    </div>
    @if(($invoice->address_id or $invoice->relay_id) and $invoice->delivery_mode_id and !$invoice->payment_method_id)
        <div class="card-body">
            @php
                /* $data = array(
                    'merchantId' => "PP-F1243",
                    'amount' => 1000,
                    'description' => "Api PHP",
                    'channel' => "CARD",
                    'countryCurrencyCode' => "952",
                    'referenceNumber' => "REF-".time(),
                    'customerEmail' => "paul.ngoran@qenium.com",
                    'customerFirstName' => "Ishola",
                    'customerLastname' => "Lamine",
                    'customerPhoneNumber' => "0779851243",
                    'notificationURL' => "callback_url",
                    'returnURL' => "callback_url",
                    'returnContext' => '{"data":"data 1","data2":"data 2"}',
                );
                $data = json_encode($data);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.paiementpro.net/webservice/onlinepayment/init/curl-init.php");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                $response = curl_exec($ch);
                curl_close($ch); */

                /* ini_set("soap.wsdl_cache_enabled", 0);
                $url="https://www.paiementpro.net/webservice/OnlineServicePayment_v2.php?wsdl";
                $client = new SoapClient($url,array('cache_wsdl' => WSDL_CACHE_NONE));
                $array=array( 'merchantId'=>'PP-F1243',
                    'countryCurrencyCode'=>'952',
                    'amount'=>1000,
                    'customerId'=>1,
                    'channel'=>'CARD',
                    'customerEmail'=>'t@t.ci',
                    'customerFirstName'=>'Thierry',
                    'customerLastname'=>'Narcisse',
                    'customerPhoneNumber'=>'22507517917',
                    'referenceNumber'=>'878AABCDEFZ'.time(),
                    'notificationURL'=>'http://test.ci/notification/',
                    'returnURL'=>'http://test.ci/return/',
                    'description'=>'achat en ligne',
                    'returnContext'=>'test=2&ok=1&oui=2',
                );
                try{
                    $response=$client->initTransact($array);

                    if($response->Code==0){
                        //var_dump($response->Sessionid);die();
                        header("Location:https://www.paiementpro.net/webservice/onlinepayment/processing_v
                        2.php?sessionid=".$response->Sessionid);
                    }
                }
                catch(Exception $e){
                    echo $e->getMessage();
                } */
            @endphp
            <form class="row">
                @foreach ($payments as $item)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="custom-control custom-radio">
                                    <input wire:model='payment' value="{{ $item->subtitle }}" type="radio" class="custom-control-input" id="payment-{{ $item->id }}" />
                                    <label class="custom-control-label text-dark font-weight-bold" for="payment-{{ $item->id }}">
                                        <p class="text-muted text-sm mt-3 mb-0 d-flex">
                                            @if(!empty($item->getMedia('image')->first()))
                                                <img class="float-start mr-2" width="80" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->title }}">
                                            @endif
                                            <span class="d-inline-block ms-4">
                                                {{ $item->title }}
                                            </span>
                                            {!! $item->content !!}
                                        </p>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @error('payment')
                    <div class="col-12">
                        <div class="text-danger mb-3" style="margin-top: -10px;">
                            <strong>{{ $message }}</strong>
                        </div>
                    </div>
                @enderror
                <div class="col-12 text-end">
                    <button type="button" wire:loading.class="bg-dark text-white" wire:loading.attr="disabled" wire:click='paymentNext' class="btn btn-warning text-uppercase">
                        <i class="icofont-double-right"></i>
                        Continuer
                        <div wire:loading wire:target='paymentNext'>
                            <span class="spinner-border spinner-border-sm"></span>
                        </div>
                    </button>
                </div>
            </form>

            <form class="checkout woocommerce-checkout" enctype="multipart/form-data">
                {{-- <div id="order_review" class="woocommerce-checkout-review-order">
                    <div id="payment" class="woocommerce-checkout-payment">
                        <ul class="wc_payment_methods payment_methods methods">
                            <li class="wc_payment_method payment_method_paiementpro_gateway">
                                <input id="payment_method_paiementpro_gateway" type="radio" class="input-radio" name="payment_method" value="paiementpro_gateway" checked="checked" data-order_button_text="" style="display: none;" />
                                <div class="payment_box payment_method_paiementpro_gateway">
                                    <div class="paymentpro-card-checkout" align="center">
                                        <div class="paymentpro-elements-field">
                                            <img class="paymentpro-image" src="https://palaisdelanature.com/wp-content/plugins/paiementpro/assets/images/pporange.jpg" width="29" /> Orange Côte d'Ivoire
                                            <input type="radio" align="center" class="paymentpro-radio" name="channel" id="pp1" value="OMCIV2" />
                                        </div>

                                        <div class="paymentpro-elements-field">
                                            <img class="paymentpro-image" src="https://palaisdelanature.com/wp-content/plugins/paiementpro/assets/images/pporange.jpg" width="29" /> Orange Burkina
                                            <input type="radio" align="center" class="paymentpro-radio" name="channel" id="pp2" value="OMBF" />
                                        </div>

                                        <div class="paymentpro-elements-field">
                                            <img class="paymentpro-image" src="https://palaisdelanature.com/wp-content/plugins/paiementpro/assets/images/pporange.jpg" width="29" /> Orange Mali
                                            <input type="radio" align="center" class="paymentpro-radio" name="channel" id="pp3" value="OMML" />
                                        </div>

                                        <div class="paymentpro-elements-field">
                                            <img class="paymentpro-image" src="https://palaisdelanature.com/wp-content/plugins/paiementpro/assets/images/ppmoov.jpg" width="29" /> Moov Money Côte d'Ivoire
                                            <input type="radio" class="paymentpro-radio" name="channel" id="pp4" value="FLOOZ" />
                                        </div>

                                        <div class="paymentpro-elements-field">
                                            <img class="paymentpro-image" src="https://palaisdelanature.com/wp-content/plugins/paiementpro/assets/images/ppmoov.jpg" width="29" /> Moov Money Benin
                                            <input type="radio" class="paymentpro-radio" name="channel" id="pp4" value="FLOOZBJ" />
                                        </div>

                                        <div class="paymentpro-elements-field">
                                            <img class="paymentpro-image" src="https://palaisdelanature.com/wp-content/plugins/paiementpro/assets/images/ppmtn.jpg" width="29" /> MTN Money Côte d'Ivoire
                                            <input type="radio" class="paymentpro-radio" name="channel" id="pp5" value="MOMOCI" />
                                        </div>

                                        <div class="paymentpro-elements-field">
                                            <img class="paymentpro-image" src="https://palaisdelanature.com/wp-content/plugins/paiementpro/assets/images/ppmtn.jpg" width="29" /> MTN Benin
                                            <input type="radio" class="paymentpro-radio" name="channel" id="pp5" value="MOMOBJ" />
                                        </div>

                                        <div class="paymentpro-elements-field">
                                            <img width="29" class="paymentpro-card-image" src="https://palaisdelanature.com/wp-content/plugins/paiementpro/assets/images/visa.svg" />
                                            <img width="29" class="paymentpro-card-image" src="https://palaisdelanature.com/wp-content/plugins/paiementpro/assets/images/mastercard.svg" /> Cartes Bancaire
                                            <input type="radio" class="paymentpro-radio" name="channel" id="pp6" value="CARD" />
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="form-row place-order">
                            <noscript>
                                Votre navigateur ne supporte pas JavaScript ou bien il est désactivé, assurez vous de cliquer sur le bouton <em>Mise à Jour Totaux</em> avant de passer votre commande. Vous pouvez être facturé plus que le montant indiqué
                                ci-dessus si vous omettez de le faire. <br />
                                <button type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="Mise à jour des totaux">Mise à jour des totaux</button>
                            </noscript>

                            <div class="woocommerce-terms-and-conditions-wrapper">
                                <div class="woocommerce-privacy-policy-text"></div>
                            </div>

                            <button type="submit" class="button alt" name="woocommerce_checkout_place_order" id="place_order" value="Commander" data-value="Commander">Commander</button>

                            <input type="hidden" id="woocommerce-process-checkout-nonce" name="woocommerce-process-checkout-nonce" value="b0e4c6dfa5" /><input type="hidden" name="_wp_http_referer" value="/?wc-ajax=update_order_review" />
                        </div>
                    </div>
                </div> --}}
                {{-- <div>
                    @foreach ($payments as $item)
                        <div class="form-check form-option form-check-inline mb-2">
                            <input type="radio" class="form-check-input" id="{{ $item->id }}" name="payment" wire:model='payment' value="{{ $item->subtitle }}">
                            <label for="{{ $item->id }}" class="form-option-label">
                                @if($item->getMedia('image')->first())
                                    <img width="30" src="{{ url($item->getMedia('image')->first()->getUrl('thumb')) }}" alt="{{ $item->title }}">
                                @endif
                                {{ $item->title }}
                            </label>
                        </div>
                    @endforeach
                </div> --}}
            </form>
        </div>
    @endif
    @if ($invoice->payment_method_id)
        <div class="card-body">
            {{ isset($invoice->paymentMethod->title) ? $invoice->paymentMethod->title : '' }}
        </div>
    @endif
</div>
