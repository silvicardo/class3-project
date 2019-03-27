var $ = require("jquery");

$(document).ready(function(){
  var latitudine = parseFloat($('#latitudine').html());
  var longitudine = parseFloat($('#longitudine').html());
  var indirizzo = $('#indirizzo').html();

  var map = tomtom.L.map('map', {
    key: 'A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh',
    source: 'vector',
    basePath: '/sdk',
  })
  //.setView([parseFloat($('#latitudine').html()), parseFloat($('#longitudine').html())], 6);

  // We will show results here
  var resultsList = tomtom.resultsList().addTo(map);

  var markersLayer = L.tomTomMarkersLayer().addTo(map);

  clear();
  var options = {
    language:  'it-IT',
    unwrapBbox: true,
    query: indirizzo,
    limit: "1",
    radius: "0",
    center: { lat: latitudine, lon: longitudine },
    geoBias: "on",
    position: longitudine,
  }

  console.log(options);

  tomtom.geocode(options).go(function(geoResponses) {

    if (geoResponses.length > 0) {
      var markerOpt = {
        noMarkerClustering: true
      };
      var popupOpt = {
        popupHoverContent: getResultAddress,
        popupContent: prepareResultElement
      };

      markersLayer.setMarkersData(geoResponses)
      .setMarkerOptions(markerOpt)
      .setPopupOptions(popupOpt)

      .addMarkers();

      resultsList.clear().unfold();

      markersLayer.getMarkers().forEach(function(markerLayer, index) {
        var point = geoResponses[index];
        var geoResponseWrapper = prepareResultElement(point);

        var viewport = point.viewport;
        resultsList.addContent(geoResponseWrapper);

        geoResponseWrapper.onclick = function() {
          if (viewport) {
            map.fitBounds([viewport.topLeftPoint, viewport.btmRightPoint]);
          } else {
            map.panTo(markerLayer.getLatLng());
          }
          markerLayer.openPopup();
        };
      });

      map.fitBounds(markersLayer.getBounds());
    } else {
      resultsList.setContent('Results not found.');
    }
  });

  /*
  * Get result address from response
  */
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
  /*
  *
  * Get result distance from search center
  */
  function getResultDistance(result) {
    if (typeof result.dist !== 'undefined') {
      return result.dist;
    }
    return null;
  }
  /*
  * Prepare result element for popup and result list
  */
  function prepareResultElement(result) {
    var resultElement = tomtom.L.DomUtil.create('div', 'geoResponse-result');
    var adress = getResultAddress(result);
    var distance = getResultDistance(result);
    if (typeof adress !== 'undefined') {
      var addressWrapper = tomtom.L.DomUtil.create('div', 'geoResponse-result-address');
      addressWrapper.innerHTML = adress;
      resultElement.appendChild(addressWrapper);
    }
    if (typeof distance !== 'undefined') {
      var distanceElement = tomtom.L.DomUtil.create('div', 'geoResponse-result-distance');
      distanceElement.innerHTML = tomtom.unitFormatConverter.formatDistance(distance);
      resultElement.appendChild(distanceElement);
    }
    return resultElement;
  }
  /*
  * Reflect changes on the map in the input
  */
  map.on('dragend', function() {
    var center = map.getCenter();
  });

  map.on('zoomend', function() {
    var center = map.getCenter();
  });

  /*

  * Clears markers and geocode results.
  */
  function clear() {
    resultsList.clear();
    markersLayer.clearLayers();
  }

});
