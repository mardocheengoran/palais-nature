@include('layouts.header')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card p-4 mt-3 mb-6 align-center">
                <a href="{{ route('invoice.all') }}">
                    <button class=" btn btn-warning py-2 px-4 rounded">
                        <h6 class="text-light"><b>Retour</b></h6>
                    </button>
                </a>
            </div>
        </div>

    </div>
    <div class="card p-4 mt-3 mb-6 pb-5">
       <div class="first d-flex justify-content-between align-items-center mb-3">
         <div class="">
        <span class="order font-bold"><b> Commande N°{{$invoice->code}} </b></span>

        <span class="d-block name"> {{$invoice->quantity}} article(s)</span>
        <span class="d-block name">Effectuée le {{$invoice->created_at->isoFormat('dddd D MMMM YYYY')}}</span>
        <span class="d-block name"><b>  Total: {{devise($invoice->price_final)}} </b></span>


        </div>

        <span class="m-0 badge bg-warning" >{{$invoice->state->title}}</span>

       </div>
       <hr>
       <h6><b>ARTICLE(S) DANS VOTRE COMMANDE</b></h6>
       <div class="card rounded-lg  px-4 py-3 border border-gray-200">


        <div class="row">
            @foreach ($invoice->articles as $article )
            <div class="col-lg-4">
                <img  class="w-50  rounded-full object-cover" src="{{ url($article->getMedia('image')->first()->getUrl('normal')) }}" alt="{{ $article->title }}">
            </div>
            <div class="col-lg-2">
                <p>
                    {{ $article->title }}
                </p>
            </div>

            <div class="col-lg-1">
                <p>
                    {{ $article->pivot->quantity }}
                </p>
            </div>

            <div class="col-lg-3">
               <p>
                Prix :  {{ devise($article->price_new) }}
               </p>

            </div>

            <div class="col-lg-2">
                <p>
                    Total: {{ devise($article->pivot->price_total) }}
                </p>
            </div>
            @endforeach
        </div>


        </div>
        <div class="row py-3">
            <div class="col">
                <div class="card rounded-lg  px-4 py-2 border border-gray-200">
                     <b><span>Paiement</span></b>
                     <hr>
                     <span>
                        <b>
                            Mode de Paiement
                        </b>
                    </span>
                    <span>
                        {{ $invoice->paymentMethod->title }}
                    </span>
                    <br>
                    <span>
                        <b>
                           Détails du paiement
                        </b>
                    </span>
                    <span class="text-gray-200">
                       Sous-total : {{ devise($invoice->price_ht) }}
                    </span>
                    <span>
                        Frais de livraison :{{ devise($invoice->price_delivery) }}
                    </span>
                    <br>
                    <span>
                       <b> Total :{{ devise($invoice->price_final) }} </b>
                    </span>



                </div>
            </div>
            <div class="col">
                <div class="card rounded-lg  px-4 py-2 border border-gray-200">
                    <b><span>Livraison</span></b>
                    <hr>
                    <span>
                        <b>
                           Méthode de livraison
                        </b>
                    </span>
                    <span>
                        {{ $invoice->deliveryMode->title }}
                    </span>
                    <br>
                    <span>
                        <b>
                           Addresse de livraison
                        </b>
                    </span>
                    <span>
                        {{ $invoice->address->title}}
                    </span>

               </div>
            </div>
          </div>
     </div>
 </div>
