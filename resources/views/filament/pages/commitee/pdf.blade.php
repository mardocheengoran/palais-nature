<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  body{
  font-family:'Times New Roman', Times, serif;
  font-size:15px;
  /* ::line-height:1 dotted; */
  color:rgb(0, 0, 0);
  background:rgb(29, 141, 233);
  max-width:1200px;
  margin:auto;
}
.flex{
  display:flex;
  flex-wrap:wrap;

}

.flex-item{
  background:rgb(255, 255, 255);
  /* //box-sizing:dotted; */
  margin:5px;
  padding:25px;
}
table{

   text-align: center;
   margin: auto;
   box-shadow: 0px 0px 9px 0px
    text-transform: uppercase;
    letter-spacing: 0.03em;
    box-shadow: 0px 0px 15px 0px rgba(0,0,0,0.1);
    justify-content: space-between;
    border-collapse: collapse;

}
p{
    text-align: center;
    align-items: center;
}

th,td {

    border: 1px solid;
    font-display: 10px;
    font-size: 20px;
    padding: 2px;

}

th{
    border-collapse: collapse;
}

h2,h3 {
    text-align: center;
    font-size: 22px;

}
.img{
    background:rgb(255, 255, 255);
    margin-left: auto;
    margin-right: auto;
    position: center;
    text-align: center;
}
img {
  display: inline-block;
}

.a{

    position: center;
    text-align: center;
}
</style>
<body>
  <div class="flex">
    <article class="flex-item w66">
        <div class="a">
            <img src="{{ public_path('img/logo.png') }}" width="155" style="border: 0; max-width: 100%; line-height: 100%; vertical-align: middle;" />
        </div>

      <h2>
        Commission :{{ $record->title }}
      </h2>
       <h3>
        Informations liées au budget
      </h3>
       <p>
          <table style="width:100%">
              <thead>
                <tr>
                  <th>Budget proposé</th>
                  <th>Budget validé</th>
                  <th>Depense</th>
                  <th>Solde</th>
                </tr>
            </thead>
             <tbody>

                <tr>
                  <td>
                      {{ devise($record->amount_propose)}}</td>
                  <td>
                      {{ devise($record->amount_valid)}}</td>
                  <td>
                      {{ devise($record->amount_expense)}}</td>
                  <td>
                      {{ devise($record->amount_sold)}}</td>
                </tr>

            </tbody>
          </table>
      </p>
    </article>
    <article class="flex-item">
      <h3>Ligne budgétaire</h3>
      <p>
        <table >
          <thead>
            <tr>
              <th scope="col" class=" px-6 py-4">Intitulé</th>
              <th scope="col" class=" px-6 py-4">Montant proposé</th>
              <th scope="col" class=" px-6 py-4">Montant validé</th>
              {{-- //<th scope="col" class=" px-6 py-4">Solde</th> --}}
            </tr>
          </thead>
          <tbody>
           @foreach ($record->budgets as $budget )
            <tr>
              <td>   {{$budget->title}}</td>
              <td>  {{$budget->amount_propose}}</td>
              <td> {{$budget->amount_valid}}</td>
              {{-- //<td class="whitespace-nowrap  px-6 py-4"> {{ devise($record->amount_sold)}}</td> --}}
            </tr>
            @endforeach
          </tbody>
        </table>
      </p>
    </article>
    <article class="flex-item">
      <h3>Membre de la Commission</h3>
      <p>
        <table style="width:100%" >
          <thead>
            <tr>
              <th>Nom</th>
              <th >Prenom</th>
              <th>Poste</th>
              {{-- //<th scope="col" class=" px-6 py-4">Solde</th> --}}
            </tr>
          </thead>
          <tbody>
             @foreach ($record->users as $user )
            <tr >
              <td > {{$user->last_name}}</td>
              <td >  {{$user->first_name}}</td>
              <td > {{$user->pivot->occupation}}</td>
              {{-- //<td class="whitespace-nowrap  px-6 py-4"> </td> --}}
            </tr>
            @endforeach
          </tbody>
        </table>
      </p>
    </article>
    <article class="flex-item">
     <h3>Tâches liées à la commission</h3>

        <table style="width:100%">
          <thead>
            <tr>
              <th>Intitulé</th>
              <th>Date debut</th>
              <th>Date fin</th>
              {{-- //<th scope="col" class=" px-6 py-4">Solde</th> --}}
            </tr>
          </thead>
          <tbody>
           @foreach ($record->tasks as $task )
            <tr>
              <td>  {{ $task->title }}</td>
              <td>   {{ $task->start_at->diffForHumans() }}</td>
              <td>  {{ $task->end_at->diffForHumans() }}</td>
              {{-- //<td class="whitespace-nowrap  px-6 py-4"> </td> --}}
            </tr>
            @endforeach
          </tbody>
        </table>
        <br>
      </p>
    </article>
    <div class="img">
        <img  src="{{ public_path('img/logo.png') }}" width="155" />
    </div>

  </div>
</body>
</html>




