
@extends('layouts.app')

@section('content')

<div class="container py-5">
  <h1>Ciao {{ $currentUser->name}},</h1>

  {{-- SCEGLI APPARTAMENTO SE NON NE È STATO PASSATO UNO --}}
  {{-- @if(!$userPassedApartment) --}}
  <form id="form_stats" action="#" method="GET" data-user-id="{{$currentUser->id}}">
    @csrf
    <div class="form-group">
       <h3 class="sponsorlabel">Scegli uno dei tuoi appartamenti:</h3>
       <select id="select-appartamento" name="apartment_id" class="form-control form-control-lg">
         @foreach ($currentUser->apartments as $apartment)
         <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
         @endforeach
       </select>
     </div>
     <button id="richiedi_stats" type="submit" class="btn btn-success">Mostra statistiche</button>
  </form>

 {{-- @endif --}}

   <div id="stats_appartamento" class="container">
     <div class="row">
       <div class="col-xl-6 py-5">
         <canvas id="chart_visualizzazioni">

         </canvas>
       </div>
       <div class="col-xl-6 py-5">
         <canvas id="chart_messaggi">

         </canvas>
       </div>
     </div>
   </div>
</div>

@endsection

@section('scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js" charset="utf-8"></script>
<script src="https://data.jsdelivr.com/v1/package/npm/node-dotenv/badge" charset="utf-8"></script>

  <script type="text/javascript">
  var $ = require("jquery");
  var Chart = require('chart.js');
  //ACCEDIAMO ALL'ENV PER LEGGERE LA CHIAVE PER LA NOSTRA API
  var dotEnv = require('dotenv');
  dotEnv.config();
  // var {MIX_API_AUTH_KEY} = process.env;


  $(document).ready(function(){

    console.log('buonanotte');
  /*
  //   var months = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
  //
  //   var graficoVisualizzazioni = new Chart($('#chart_visualizzazioni'), {
  //     "type": "line",
  //     "data": {
  //         "labels": months,
  //         "datasets": [{
  //             "label": "Visualizzazioni",
  //             "data": [70, 59, 80, 81, 56, 55, 40, 70, 59, 80, 81, 56, 55, 40],
  //             "fill": true,
  //             "borderColor": "red",
  //             "lineTension": 0.1,
  //         }]
  //     },
  //     "options": {}
  // });
  //
  //   var graficoMessaggi = new Chart($('#chart_messaggi'), {
  //     "type": "line",
  //     "data": {
  //         "labels": ["January", "February", "March", "April", "May", "June", "July"],
  //         "datasets": [{
  //             "label": "My First Dataset",
  //             "data": [65, 59, 80, 81, 56, 55, 40],
  //             "fill": false,
  //             "borderColor": "rgb(75, 192, 192)",
  //             "lineTension": 0.1
  //         }]
  //     },
  //     "options": {}
  // });
    // console.log($('#apartment_card').data('apartment-id'));
  */
      $.ajax({
        url: '/api/apartment/stats',
        method: 'GET',
        headers: {'Authorization': `Bearer ${process.env.MIX_API_AUTH_KEY}`},
        data: { apartment_id: $('#apartment_card').data('apartment-id'), user_id: $('#apartment_card').data('user-id')} ,
        success: function(response){
          console.log(response);
        },
        fail: function(error){
          console.log(error.message)
        }
      });


  });
  </script> --}}
  <script src="{{ asset('js/getUserApartmentStats.js')}}" charset="utf-8"></script>
@endsection
