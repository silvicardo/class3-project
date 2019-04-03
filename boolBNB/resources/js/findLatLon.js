
var $ = require("jquery");


$(document).ready(function(){

  console.log('latLon script');

  // Define your product name and version
  tomtom.setProductInfo('progettoClasse3', '2');
  // Setting TomTom keys
  tomtom.searchKey('A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh');

  //**************LISTENERS***********//

  $('#submit_form_appartamento').click((event)=>{
    event.preventDefault();

    var options = getOptions($('#indirizzo').val());
    console.log('options',options);

    tomtom.geocode(options).go(function(responses){

      var result = responses[0];
      console.log(result);

      //compilare gli input nascosti
      $('#input_lat').val(result.position.lat);
      $('#input_lon').val(result.position.lon);
      //ed inserire l'indirizzo tom tom nel db
      $('#indirizzo').val(getResultAddress(result));
      $('#form_appartamento').submit();

    })
  });

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

    var options = {
      language:  'it-IT',
      unwrapBbox: true,
      query: indirizzo,
      limit: "1",
      radius: "0",
      geoBias: "on",
    }

    return options;
  }

})
