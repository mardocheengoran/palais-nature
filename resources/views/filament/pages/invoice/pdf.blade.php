<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.title{
	text-align:center;
    color: #e36416 ;
}



td {


   border-top: 1px solid gray;

  font-size: 15px;

}

table {
	 width: 100%;
 	margin-left:20px;
    margin-right:20px;
  border-collapse: collapse;

}



.signature{
	font-size : 18px;
    font-weight : bold;
    color: #e36416 ;
}


.column1 {
  float: left;
  width: 30%;
}

.column2 {
  float: left;
  width: 70%;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

.a{


text-align: left;
}

.b{
text-align: right;
}


</style>
</head>
<body>

    <table style="width: 100%; ">
        <tr class="header">
          <td class="">
            <img src="{{ public_path('img/seller.png') }}" width="155" style="border: 0; max-width: 100%; line-height: 100%; " />
          </td>
          <td style=" text-align:right;">
            {{-- <img src="data:image/png;base64, {!! base64_encode(QrCode::size(90)->generate("http://127.0.0.1:8000/generate-facture/IN-00001")) !!} "> --}}

            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate(route('imprimer', $record->code)),) !!}">

          </td>
        </tr>
    </table>
    {{-- <div>
        <div class="a">
            <img src="{{ public_path('img/seller.png') }}" width="155" style="border: 0; max-width: 100%; line-height: 100%; " />
        </div>
        <div class="b">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate("https://google.com")) !!} ">
        </div>
    </div> --}}

  <h2 class="title"> Commande N°{{$record->code}} </h2>
  <br>
   <div class="row">
    <div class="column1">
        <table class="center">

            <tr>
                <td>Nom & prénoms :</td>
            </tr>

            <tr>
                <td>Email :</td>

            </tr>

            <tr>
                <td>Adresse de livraison :</td>
            </tr>

            <tr>
                <td>Mode de paiement :</td>
            </tr>

            <tr>
                <td>N° téléphone :</td>
            </tr>

            <tr>
                <td> Date et heure de livraison :</td>
            </tr>

            <tr>
                <td>Date de commande :</td>
            </tr>
        </table>

  </div>
  <div class="column2">
        <table class="center">

            <tr>
            <td>{{$record->customer->fullname}}</td>
            </tr>

            <tr>
            <td>{{$record->customer->email}}</td>
            </tr>

            <tr>
            <td>{{$record->address->title}}</td>
            </tr>

            <tr>
                <td> {{ $record->paymentMethod->title }}</td>
            </tr>

            <tr>
            <td>{{$record->customer->phone}}</td>
            </tr>

            <tr>
            <td> {{$record->planned_at->isoFormat('dddd D MMMM YYYY')}} </td>
            </tr>

            <tr>
                <td>{{$record->created_at->isoFormat('dddd D MMMM YYYY')}}</td>
            </tr>




        </table>
  </div>
</div>

<h3 class="title">
    Articles({{$record->quantity}} article(s))
</h3>

  <table style="width: 650px; height: 23px; margin-left: auto; margin-right: auto;">
<tbody>

    <tr>

    <td style="width: 414px;">&nbsp;Articles</td>
    <td style="width: 83px;">&nbsp;Quantité</td>
    <td style="width: 99.625px;">&nbsp;&nbsp;Prix unitaire</td>
    <td style="width: 97.375px;">&nbsp;Sous-total</td>
    </tr>
    @foreach ($record->articles as $article )
    <tr>


    <td style="width: 414px;">&nbsp;&nbsp; {{ $article->title }}</td>

    <td style="width: 83px;">&nbsp;{{$article->pivot->quantity}}</td>
    <td style="width: 99.625px;">&nbsp;{{ devise($article->price_new) }}</td>
    <td style="width: 97.375px;">&nbsp;{{ devise($article->pivot->price_total) }}</td>
    </tr>
    @endforeach
</tbody>
</table>
<table style="width: 650px; height: 23px; margin-left: auto; margin-right: auto;">
    <tbody>
        <tr>
            <td style="width: 20px;">
                &nbsp;
            </td>
            <td style="width: 413px;">
                &nbsp;
            </td>
            <td style="width: 56px;">
                &nbsp;
            </td>
            <td style="width: 46.4219px;">
                &nbsp;&nbsp;
            </td>
            <td style="width: 172.578px; font-weight : bold; ">
                &nbsp;Total HT:{{ devise($record->price_ht) }}
            </td>

        </tr>
        <tr>
            <td style="width: 28px;">
                &nbsp;
            </td>
            <td style="width: 413px;">
                &nbsp;
            </td>
            <td style="width: 56px;">
                &nbsp;
            </td>
            <td style="width: 46.4219px;">
                &nbsp;
            </td>
            <td style="width: 172.578px;  font-weight : bold;">
                Livraison : {{ devise($record->price_delivery) }}
            </td>
        </tr>
        <tr>
            <td style="width: 28px;">
                &nbsp;
            </td>
            <td style="width: 413px;">&nbsp;
            </td>
            <td style="width: 56px;">
                &nbsp;
            </td>
            <td style="width: 46.4219px;">
                &nbsp;
            </td>
            <td style="width: 172.578px;  font-weight : bold;">
                Total TTC : {{ devise($record->price_final) }}
            </td>
        </tr>
    </tbody>
    </table>
    <p>(+225) 20 00 05 71 / 09 09 65 51 / 75 03 42 03 / 02 71 71 86</p>
    <p>info@bezo.ci</p>
    <span><p>

NB : Cher client(e), nous vous prions de bien vérifier la qualité et la Quantité des produits de votre commande à la livraison.
Car, après le départ du livreur du lieu de livraison, aucune réclamation ne sera recevable.
Merci de toujours nous faire confiance. A très bientôt ! </p></span>

    <p class="signature">Signature</p>





</body>
</html>
