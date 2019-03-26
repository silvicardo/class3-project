
var $ = require("jquery");
import Handlebars from 'handlebars/dist/cjs/handlebars.js';

//import {tomtom} from './../sdk/tomtom.min.js';

$(document).ready(function(){

  //mostraMappaTomtom(tomtom);

  richiediCoordinate();

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

    // var form = document.getElementById('advanced_form');
    var form = $('#advanced_form');

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

  // async function richiediCoordinate(){
  //   var risultati = await $.getJSON('https://api.tomtom.com/search/2/geocode/4 north 2nd street san jose.json?storeResult=true&countrySet=US&lat=37.337&lon=-121.89&topLeft=37.553%2C-122.453&btmRight=37.4%2C-122.55&language=it-IT&view=Unified&key=A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh');
  //
  //   console.log(risultati);
  //
  // }

  // function mostraMappaTomtom(tomtom){
  //   tomtom.setProductInfo('progettoClasse3', '2');
  //   tomtom.L.map('map', {
  //     key: 'A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh',
  //     source: 'vector',
  //     basePath: '/sdk'
  //   });
  // }
})
