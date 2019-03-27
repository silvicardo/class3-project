var $ = require("jquery");

$(document).ready(function(){


  var latInput = $('#latParam');
  var lonInput = $('#lonParam');
  var limit = $('#limit');
  var radius = $('#radius');
  var geoBias = $('#geoBias');

  // Define your product name and version
  tomtom.setProductInfo('progettoClasse3', '2');
  // Setting TomTom keys
  tomtom.searchKey('A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh');

  var options = getOptions()
    // debugger
  tomtom.geocode(options).go(function(responses){
    var result = responses[0];
        // debugger
    var toDb = {
      lat: result.position.lat,
      lon: result.position.lon,
      fullAddress: getResultAddress(result),
      radius: 20
    }
  });

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

  function handleRangeUpdate() {
    $('#radiusLabel').html('Radius (' + radius.value + ' m)');
    $('#limitAmount').html('Limit (' + limit.value + ')');
  }

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

  function getOptions() {
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
      query: $('#citta_cercata').val(),
      limit: "1",
      radius: "0",
      // center: { lat: "39.0898543", lon: "1.6328772"},
      geoBias: "on",
      // position: "1.6328772",
    }

    return options;
  }

});
