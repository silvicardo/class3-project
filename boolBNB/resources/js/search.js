
var $ = require("jquery");
// var tomtom = require('./tomtom.min.js');
import Handlebars from 'handlebars/dist/cjs/handlebars.js';

// import {tomtom} from './tomtom.min.js';

$(document).ready(function(){

  //mostraMappaTomtom(tomtom);

  // richiediCoordinate();
  // console.log(window.tomtom);
  console.log('search script');

  // (function(tomtom) {
  //
  //   // Define your product name and version
  //   tomtom.setProductInfo('progettoClasse3', '2');
  //   // Setting TomTom keys
  //   tomtom.searchKey('A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh');
  //
  //   // Creating map
  //   var map = tomtom.L.map('map', {
  //     key: 'A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh',
  //     source: 'vector',
  //     basePath: '/sdk',
  //   });
  //
  //
  //
  //   var languageSelector = tomtom.languageSelector.getHtmlElement(new tomtom.localeService(), 'search');
  //   // var langParam = document.getElementById('langParam');
  //   // langParam.insertBefore(languageSelector, langParam.firstChild);
  //
  //
  //   // We will show results here
  //   var resultsList = tomtom.resultsList()
  //   .addTo(map);
  //
  //
  //   var markersLayer = L.tomTomMarkersLayer().addTo(map);
  //   var latInput = document.getElementById('latParam');
  //   var lonInput = document.getElementById('lonParam');
  //   //var limit = document.getElementById('limit');
  //   var radius = document.getElementById('radius');
  //   var geoBias = document.getElementById('geoBias');
  //
  //   function handleRangeUpdate() {
  //     document.getElementById('radiusLabel').innerHTML = 'Radius (' + radius.value + ' m)';
  //     //document.getElementById('limitAmount').innerHTML = 'Limit (' + limit.value + ')';
  //   }
  //
  //   //limit.onchange = handleRangeUpdate;
  //   radius.onchange = handleRangeUpdate;
  //
  //   function enableGeoBiasCheckbox() {
  //     if (!geoBias.checked) {
  //       geoBias.checked = true;
  //       turnControlOnOrOff(true);
  //     }
  //   }
  //
  //   document.getElementById('geoBiasMessage').addEventListener('click', enableGeoBiasCheckbox);
  //
  //   function turnControlOnOrOff(onOffFlag) {
  //     var visibility = 'flex';
  //     var geoBiasMessage = '';
  //
  //     if (!onOffFlag) {
  //       visibility = 'none';
  //       geoBiasMessage = 'Geo Bias is turned off';
  //     }
  //
  //     document.getElementById('radiusParam').style.display = visibility;
  //     document.getElementById('latParamElement').style.display = visibility;
  //     document.getElementById('lonParamElement').style.display = visibility;
  //     document.getElementById('geoBiasMessage').innerText = geoBiasMessage;
  //   }
  //
  //   geoBias.addEventListener('click', function() {
  //     turnControlOnOrOff(geoBias.checked);
  //   });
  //
  //
  //   // Submit button click handler
  //
  //    document.getElementById('tomtom-example-submit').onclick = function() {
  //
  //
  //     clear();
  //     var options = getOptions();
  //     if (!options) {
  //       return true;
  //     }
  //
  //     tomtom.geocode(options).go(function(geoResponses) {
  //       if (geoResponses.length > 0) {
  //         var markerOpt = {
  //           noMarkerClustering: true
  //         };
  //
  //         var popupOpt = {
  //           popupHoverContent: getResultAddress,
  //           popupContent: prepareResultElement
  //         };
  //
  //         markersLayer.setMarkersData(geoResponses)
  //         .setMarkerOptions(markerOpt)
  //         .setPopupOptions(popupOpt)
  //         .addMarkers();
  //
  //         resultsList.clear().unfold();
  //         markersLayer.getMarkers().forEach(function(markerLayer, index) {
  //           var point = geoResponses[index];
  //           var geoResponseWrapper = prepareResultElement(point);
  //           var viewport = point.viewport;
  //           resultsList.addContent(geoResponseWrapper);
  //           geoResponseWrapper.onclick = function() {
  //             if (viewport) {
  //               map.fitBounds([viewport.topLeftPoint, viewport.btmRightPoint]);
  //             } else {
  //               map.panTo(markerLayer.getLatLng());
  //             }
  //             markerLayer.openPopup();
  //           };
  //         });
  //
  //         drawSearchCenterMarker();
  //         map.fitBounds(markersLayer.getBounds());
  //       } else {
  //         resultsList.setContent('Results not found.');
  //       }
  //     });
  //     return false;
  //   };
  //
  //   /*
  //   * Get result address from response
  //   */
  //   function getResultAddress(result) {
  //     if (typeof result.address === 'undefined') {
  //       return '';
  //     }
  //
  //     var address = [];
  //
  //     if (typeof result.address.freeformAddress !== 'undefined') {
  //       address.push(result.address.freeformAddress);
  //     }
  //
  //     if (typeof result.address.countryCodeISO3 !== 'undefined') {
  //       address.push(result.address.countryCodeISO3);
  //     }
  //
  //     return address.join(', ');
  //   }
  //
  //   /*
  //   * Draw search center position
  //   */
  //   function drawSearchCenterMarker() {
  //     if (!geoBias.checked) {
  //       return;
  //     }
  //
  //     var currentLocation = getInputLatLng();
  //     var markerOptions = {
  //       title: 'Search Center\nLatitude: ' + currentLocation[0] +
  //       '\nLongitude: ' + currentLocation[1],
  //       icon: tomtom.L.icon({
  //         iconUrl: '/sdk/../img/center_marker.svg',
  //         iconSize: [24, 24],
  //         iconAnchor: [12, 12]
  //       })
  //     };
  //
  //     markersLayer.addLayer(tomtom.L.marker([currentLocation[0], currentLocation[1]], markerOptions)).addTo(map);
  //   }
  //
  //   /*
  //   * Get result distance from search center
  //   */
  //   function getResultDistance(result) {
  //     if (typeof result.dist !== 'undefined') {
  //       return result.dist;
  //     }
  //     return null;
  //   }
  //
  //   /*
  //   * Prepare result element for popup and result list
  //   */
  //   function prepareResultElement(result) {
  //     var resultElement = tomtom.L.DomUtil.create('div', 'geoResponse-result');
  //
  //     var adress = getResultAddress(result);
  //     var distance = getResultDistance(result);
  //
  //     if (typeof adress !== 'undefined') {
  //       var addressWrapper = tomtom.L.DomUtil.create('div', 'geoResponse-result-address');
  //       addressWrapper.innerHTML = adress;
  //       resultElement.appendChild(addressWrapper);
  //     }
  //     if (typeof distance !== 'undefined') {
  //       var distanceElement = tomtom.L.DomUtil.create('div', 'geoResponse-result-distance');
  //       distanceElement.innerHTML = tomtom.unitFormatConverter.formatDistance(distance);
  //       resultElement.appendChild(distanceElement);
  //     }
  //
  //     return resultElement;
  //   }
  //
  //   /*
  //   * Reflect changes on the map in the input
  //   */
  //   map.on('dragend', function() {
  //     var center = map.getCenter();
  //     latInput.value = center.lat.toFixed(7);
  //     lonInput.value = center.lng.toFixed(7);
  //   });
  //
  //   map.on('zoomend', function() {
  //     var center = map.getCenter();
  //     latInput.value = center.lat.toFixed(7);
  //     lonInput.value = center.lng.toFixed(7);
  //   });
  //
  //   function getInputLatLng() {
  //     var coords = [latInput.value, lonInput.value];
  //     if (coords.length !== 2 || !isNumber(coords[0]) || !isNumber(coords[1])) {
  //       tomtom.messageBox({ closeAfter: 3000 }).setContent('Incorrect position!').openOn(map);
  //       return false;
  //     }
  //     return [coords[0].trim(), coords[1].trim()];
  //   }
  //
  //   latInput.onchange = function() {
  //     var center = getInputLatLng();
  //     if (center) {
  //       map.setView(center);
  //     }
  //   };
  //
  //   lonInput.onchange = function() {
  //     var center = getInputLatLng();
  //     if (center) {
  //       map.setView(center);
  //     }
  //   };
  //
  //   function isNumber(n) {
  //     return !isNaN(parseFloat(n)) && isFinite(n);
  //   }
  //
  //   /*
  //   * Gets entered options from form fields
  //   */
  //   function getOptions() {
  //     var wrapper = document.getElementById('tomtom-example-inputsWrapper');
  //     var inputs = wrapper.getElementsByTagName('input');
  //     var options = {unwrapBbox: true};
  //     for (var i = 0; i < inputs.length; i += 1) {
  //       var input = inputs[i];
  //       if (input.name && input.value && (input.type !== 'radio' || input.checked)) {
  //         options[input.name] = input.value;
  //       }
  //     }
  //
  //     var selectedLangCode = languageSelector.options[languageSelector.selectedIndex].value;
  //
  //     options.language = selectedLangCode;
  //
  //     if (!geoBias.checked) {
  //       delete options.radius;
  //       return options;
  //     }
  //
  //     var center = getInputLatLng();
  //     if (!center) {
  //       return false;
  //     }
  //     options.center = {
  //       lat: center[0],
  //       lon: center[1]
  //     };
  //     return options;
  //   }
  //
  //   /*
  //   * Clears markers and geocode results.
  //   */
  //   function clear() {
  //     resultsList.clear();
  //     markersLayer.clearLayers();
  //   }
  //
  // })(tomtom, window);
  //

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
