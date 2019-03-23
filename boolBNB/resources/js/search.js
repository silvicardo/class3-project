
var $ = require("jquery");
import Handlebars from 'handlebars/dist/cjs/handlebars.js';

$(document).ready(function(){

  console.log('search script');

  //**************VARIABILI***********//

  var isAdvanced = false;

  //**************PRIMO AVVIO PAGINA***********//

  avviaRicercaCon();//default città nella barra di ricerca e tipo ricerca non avanzata

  //**************LISTENERS***********//

  $('#toggle_advanced').click(function(){

    isAdvanced = !isAdvanced;

    $('.filtriRicerca').toggleClass('d-none');

  })

  $('#go_search').click(function(){

    avviaRicercaCon(estraiDatiPerRicercaDallaPagina(), isAdvanced)

  });

  //**************FUNZIONI***********//

  async function avviaRicercaCon(parametri = {citta_cercata: $('#citta_cercata').val()}, isAdvanced = false){

    console.log('isAdvanced search = ', isAdvanced);

    var apartments = await $.post('api/search-city', { isAdvanced, ...parametri});

    console.log('ilJson', apartments);

    stampaAppartamenti(apartments)

  }

  function estraiDatiPerRicercaDallaPagina(){

    var form = document.getElementById('advanced_form');

    var dalForm = Object.values(form).reduce((obj,input) => {
      if (input.type === 'checkbox'){
        if (input.checked === true ) { obj.optionals.push(input.value) }
      } else {
        obj[input.name] = input.value;
      }
       return obj },
       {optionals: []})

    dalForm.citta_cercata = $('#citta_cercata').val();

    return dalForm;
  }

  function stampaAppartamenti(apartments){

    $('#risultati').html('');

    apartments.forEach(function(apartment){

      var source   = $("#apartment_template").html();
      var template = Handlebars.compile(source);

      //link, image_url, title, description
      var context = {...apartment, link: `apartment/${apartment.id}`};
      // apartment.link = `http:localhost:8000/apartment/${apartment.id}`;
      var html    = template(context);
      $('#risultati').append(html)

    });
  }


})
