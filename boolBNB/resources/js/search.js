
var $ = require("jquery");

import Handlebars from 'handlebars/dist/cjs/handlebars.js';

$(document).ready(function(){

  console.log('search script');

  //**************VARIABILI***********//

  var isAdvanced = false;

  //**************PRIMO AVVIO PAGINA***********//

  // Define your product name and version
  tomtom.setProductInfo('progettoClasse3', '2');
  // Setting TomTom keys
  tomtom.searchKey('A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh');

  searchAndShowApartmentsFromOptions();

  //**************LISTENERS***********//

  $('#toggle_advanced').click(function(){

    isAdvanced = !isAdvanced;

    $('.filtriRicerca').toggleClass('d-none');

  })

  $('#go_search').click(searchAndShowApartmentsFromOptions);


  //**************FUNZIONI***********//

  async function searchAndShowApartmentsFromOptions() {

  console.log('isAdvanced search = ', isAdvanced);

  const responses  = await tomtom.geocode(createOptions()).go();

  const { lat, lon } = responses[0].position;

  const apartments = await $.post('api/search-city', {...extractDataFromOptionsForm(), lat, lon });

  console.log('JSON appartamenti trovati ', apartments);

  showApartments(apartments);

}

  function extractDataFromOptionsForm(){

    var formData = document.getElementById('advanced_form');

    var formDataObj = Object.values(formData).reduce((obj,input) => {

      if (input.value === undefined || input.value === '' || input.name === '_token' ) return obj;

      if (input.type === 'checkbox'){
        if (input.checked === true )  obj.optionals.push(input.value) ;
      } else {
        obj[input.name] = input.value;
      }
       return obj },
       { optionals: [], radius: 20 })

     console.log('dati dal form', formDataObj);

      return {...formDataObj, citta_cercata: $('#citta_cercata').val() }

  }

  function showApartments(apartments){

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

  function getResultAddress({address}) {
    console.log(address);
    if (typeof address === 'undefined') {
      return '';
    }

    var addressParts = [];

    if (typeof address.freeformAddress !== 'undefined') {
      addressParts.push(address.freeformAddress);
    }

    if (typeof address.countryCodeISO3 !== 'undefined') {
      addressParts.push(address.countryCodeISO3);
    }

    return addressParts.join(', ');
  }

  function createOptions() {

  return {
      language:  'it-IT',
      unwrapBbox: true,
      query: $('#citta_cercata').val(),
      limit: "1",
      radius: "0",
      geoBias: "on",
    }

  }

});
