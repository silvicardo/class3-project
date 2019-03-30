var $ = require("jquery");

$(document).ready(function(){

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
  $('#mostraMappa, #nascondiMappa, #mostraForm, #nascondiForm')
    .on('click', () => {
    //TOGGLO MAPPA
    $('#mapContainer').toggleClass('d-none');
    $('#mostraMappa').toggleClass('d-none');
    $('#nascondiMappa').toggleClass('d-none');
    //TOGGLO FORM
    $('#form').toggleClass('d-none');
    $('#mostraForm').toggleClass('d-none');
    $('#nascondiForm').toggleClass('d-none');
  });

  //AL DRAG DELLA MAPPA RIPOSIZIONA IL CENTRO DELLA MAPPA
  map.on('dragend', function() {
    var center = map.getCenter();
  });

  map.on('zoomend', function() {
    var center = map.getCenter();
  });

});
