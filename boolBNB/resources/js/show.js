var $ = require("jquery");
//ACCEDIAMO ALL'ENV PER LEGGERE LA CHIAVE PER LA NOSTRA API
var dotEnv = require('dotenv');
dotEnv.config();
var {MIX_API_AUTH_KEY} = process.env;


$(document).ready(function(){

  console.log($('#apartment_card').data('apartment-id'));
  //INCREMENTA IL COUNTER DI VISITE DI UN DETERMINATO APPARTAMENTO
    $.ajax({
      url: '/api/apartment/update-nr-of-views',
      method: 'POST',
      headers: {'Authorization': `Bearer ${MIX_API_AUTH_KEY}`},
      data: { apartment_id: $('#apartment_card').data('apartment-id'), user_id: $('#apartment_card').data('user-id')} ,
      success: function(response){
        console.log(response);
      },
      fail: function(error){
        console.log(error.message)
      }
    });

  var latitudine = parseFloat($('#latitudine').html());
  var longitudine = parseFloat($('#longitudine').html());
  var center = [latitudine, longitudine];
  var indirizzo = $('#indirizzo').html();

  //CREAZIONE MAPPA
  var map = tomtom.L.map('map', {
    key: 'A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh',
    center,
    source: 'vector',
    basePath: '/sdk',
  }).setView(center, 17)

  //LA RESULT LIST È NECESSARIA, VA CREATA MA NON LA MOSTRIAMO
  var resultsList = tomtom.resultsList().addTo(map);
  $('.tomtom-results-list').addClass('d-none');

  //METTIAMO IL MARKER SULL'INDIRIZZO DELL'APPARTAMENTO
  var markersLayer = L.tomTomMarkersLayer().addTo(map);
  var marker = tomtom.L.marker(center, { draggable: false }).bindPopup(indirizzo).addTo(map);

  //AL CLICK DEI BOTTONI TOGGLO MAPPA/FORM
  // $('#mostraMappa, #nascondiMappa, #mostraForm, #nascondiForm')
  //   .on('click', () => {
  //   //TOGGLO MAPPA
  //   $('#mapContainer').toggleClass('d-none');
  //   $('#mostraMappa').toggleClass('d-none');
  //   $('#nascondiMappa').toggleClass('d-none');
  //   //TOGGLO FORM
  //   $('#form').toggleClass('d-none');
  //   $('#mostraForm').toggleClass('d-none');
  //   $('#nascondiForm').toggleClass('d-none');
  // });
  $('#nascondiMappa').click(function() {
    $('#mapContainer').slideUp('fast');
    $('#mostraMappa').toggleClass('d-none');
    $('#nascondiMappa').toggleClass('d-none');
  });
  $('#mostraMappa').click(function() {
    $('#mapContainer').slideDown('fast');
    $('#mostraMappa').toggleClass('d-none');
    $('#nascondiMappa').toggleClass('d-none');
  })
  $('#mostraForm').click(function() {
    $('#form').removeClass('d-none').slideDown('fast');
    $('#mostraForm').toggleClass('d-none');
    $('#nascondiForm').toggleClass('d-none');
  });
  $('#nascondiForm').click(function() {
    $('#form').slideUp('fast');
    $('#mostraForm').toggleClass('d-none');
    $('#nascondiForm').toggleClass('d-none');
  })

  //AL DRAG DELLA MAPPA RIPOSIZIONA IL CENTRO DELLA MAPPA
  map.on('dragend', function() {
    var center = map.getCenter();
  });

  map.on('zoomend', function() {
    var center = map.getCenter();
  });


});
