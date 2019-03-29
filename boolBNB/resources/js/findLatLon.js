
var $ = require("jquery");


$(document).ready(function(){

  console.log('latLon script');

  //*********PUNTATORI JQUERY********//


  //**************VARIABILI***********//



  //**************PRIMO AVVIO PAGINA***********//


  // Define your product name and version
  tomtom.setProductInfo('progettoClasse3', '2');
  // Setting TomTom keys
  tomtom.searchKey('A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh');

  //**************LISTENERS***********//



  $('#submit_form_appartamento').click((event)=>{
    event.preventDefault();

    var options = getOptions($('#indirizzo').val(),);
    console.log('options',options);

    tomtom.geocode(options).go(function(responses){

      var result = responses[0];
      console.log(result);

      //compilare gli input nascosti
      $('#input_lat').val(result.position.lat);
      $('#input_lon').val(result.position.lon);
      
      $('#form_appartamento').submit();

    })
  });

  //**************FUNZIONI***********//


  function estraiDatiPerRicercaDallaPagina(){

    // var form = $('#advanced_form');
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

  //*********FUNZIONI TOMTOM*****************//

  function getResultAddress(result) {
    if (typeof result.address === 'undefined') {
      return '';
    }

    var address = [];

    if (typeof result.address.freeformAddress !== 'undefined') {
      address.push(result.address.freeformAddress);
    }

    if (typeof result.address.countryCodeISO3 !== 'undefined') {
      address.push(result.address.countryCodeISO3);
    }

    return address.join(', ');
  }

  function getOptions(indirizzo) {
    // var wrapper = $('#tomtom-example-inputsWrapper');
    // var inputs = wrapper.getElementsByTagName('input');
    // var options = {unwrapBbox: true};
    // for (var i = 0; i < inputs.length; i += 1) {
    //   var input = inputs[i];
    //   if (input.name && input.value && (input.type !== 'radio' || input.checked)) {
    //     options[input.name] = input.value;
    //   }
    // }
    //

    var options = {
      language:  'it-IT',
      unwrapBbox: true,
      query: indirizzo,
      limit: "1",
      radius: "0",
      // center: { lat: "39.0898543", lon: "1.6328772"},
      geoBias: "on",
      // position: "1.6328772",
    }

    return options;
  }



  function handleRangeUpdate() {
    $('#radiusLabel').html('Radius (' + radius.value + ' m)');
    $('#limitAmount').html('Limit (' + limit.value + ')');
  }

  // function getResultDistance(result) {
  //   if (typeof result.dist !== 'undefined') {
  //     return result.dist;
  //   }
  //   return null;
  // }

  // function getInputLatLng() {
  //   var coords = [latInput.value, lonInput.value];
  //   if (coords.length !== 2 || !isNumber(coords[0]) || !isNumber(coords[1])) {
  //     tomtom.messageBox({ closeAfter: 3000 }).setContent('Incorrect position!').openOn(map);
  //     return false;
  //   }
  //   return [coords[0].trim(), coords[1].trim()];
  // }


  //
  function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }

  async function datiPosizioneCercataPerDb(){
    var options = getOptions();
    console.log('options',options);
    var geocodeResult = await tomtom.geocode(options)
    console.log(geocodeResult);
    var toDb = await geocodeResult.go(function(responses){
        console.log('geoce');
      var result = responses[0];

      var toDb = {
        lat: result.position.lat,
        lon: result.position.lon,
        fullAddress: getResultAddress(result)
      }

      // viale ceccarini 20 riccione

      //indirizzo trovato
      console.log('toDb',toDb);

    })
    return toDb;
  }


})
