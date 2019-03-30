var $ = require("jquery");
import Chart from 'chart.js';
//ACCEDIAMO ALL'ENV PER LEGGERE LA CHIAVE PER LA NOSTRA API
var dotEnv = require('dotenv');
dotEnv.config();
// var {MIX_API_AUTH_KEY} = process.env;


$(document).ready(function(){

  console.log('buonanotte');

  $('#richiedi_stats').click(function(){
    var idAppartamentoScelto = $('#select-appartamento').val();
    var userId = $('#form_stats').data('user-id');

    console.log(idAppartamentoScelto);
    console.log(userId);

  /*

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
        headers: {
        Authorization: `Bearer ${process.env.MIX_API_AUTH_KEY}`,
         apartment_id: idAppartamentoScelto,
         user_id: userId} ,
        success: function(response){

          console.log(response.views.anni.mesi);

          var visitePerMese = response.views.anni.mesi
          var messaggiPerMese = response.messaggi.anni.mesi
          var months = ["January", "February", "March", "April", "May", "June", "July","August","September","October","November","December"];
          var views = [0,0,0,0,0,0,0,0,0,0,0,0];
          var messaggi = [0,0,0,0,0,0,0,0,0,0,0,0];

          for (var key in response.views.anni.mesi) {
            if(months.includes(key)){
              console.log('ci sta ' + key);
              views[months.indexOf(key)] = response.views.anni.mesi[key].length;
            }
          }
          for (var key in response.messaggi.anni.mesi) {
            if(months.includes(key)){
              console.log('ci sta ' + key);
              messaggi[months.indexOf(key)] = response.messaggi.anni.mesi[key].length
            }
          }

            console.log(views);

              var mesiItalia = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];

              var graficoVisualizzazioni = new Chart($('#chart_visualizzazioni'), {
                "type": "line",
                "data": {
                    "labels": mesiItalia,
                    "datasets": [{
                        "label": "Visualizzazioni",
                        "data": views,
                        "fill": true,
                        "borderColor": "red",
                        "lineTension": 0.1,
                    }]
                },
                "options": {}
            });


              var graficoMessaggi = new Chart($('#chart_messaggi'), {
                "type": "line",
                "data": {
                    "labels": mesiItalia,
                    "datasets": [{
                        "label": "Messaggi",
                        "data": messaggi,
                        "fill": false,
                        "borderColor": "rgb(75, 192, 192)",
                        "lineTension": 0.1
                    }]
                },
                "options": {}
            });


        },
        fail: function(error){
          console.log(error.message)
        }
      });
  })




});
