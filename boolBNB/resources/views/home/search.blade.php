@extends('layouts.app')

@section('content')
  <div class="container py-5">

    <div id="sto_caricando" class="d-none">

        <p>Sto caricando la ricerca</p>

        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
        </div>


    </div>

    <div id="ho_caricato">

      {{-- inizio mappa --}}

      {{-- <link rel='stylesheet' type='text/css' href="{{ asset('sdk/map.css')}}"/>
      <script src="{{ asset('sdk/tomtom.min.js') }}"></script>
      <div id='map' style='height:500px;width:500px'></div>
        <script>
    	    tomtom.setProductInfo('progettoClasse3', '2');
          tomtom.L.map('map', {
		        key: 'A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh',
            center: [37.769167, -122.478468],
            source: 'vector',
            basePath: '/sdk',
            zoom: 15
    	    });
        </script> --}}

        <head>
          <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
          <meta charset='UTF-8'>
          <title>Maps SDK for Web - Map</title>
          <meta name='viewport' content='width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no'/>
          <link rel='stylesheet' type='text/css' href="{{ asset('sdk/map.css')}}"/>
          <link rel='stylesheet' type='text/css' href="{{ asset('sdk/elements.css')}}">
          <link rel='stylesheet' type='text/css' href="{{ asset('sdk/assets/css/tomtom2.css')}}">
          <script type='text/javascript' src={{ asset('sdk/js/form.js')}}></script>
          <script src="{{ asset('sdk/tomtom.min.js') }}"></script>
        </head>
        <body class='use-all-space'>
          <div class='flex-horizontal use-all-space'>
            <div id='tomtom-example-inputs' class='sidepanel'>
              {{-- <h4>Geocode parameters</h4> --}}
              <form onsubmit='return false'>
                <div id='tomtom-example-inputsWrapper' class='scrollbar'>
                  {{-- <div id='langParam' class='sidepanel-input-group'>
                    <label>Language</label>
                  </div> --}}

                  <div class='sidepanel-input-group'>
                    {{-- <input id="citta_cercata" type="text" class="form-control" placeholder="Cerca città" aria-label="Recipient's username with two button addons" aria-describedby="button-addon4" value="{{ $citta_cercata }}"> --}}
                    <input type='text' id='citta_cercata query' name='query' value="{{ $citta_cercata }}" placeholder='Cerca città' pattern='.+'
                    title='this field is required' required>
                    <label for='query'>Città</label>
                  </div>
                  <div class='sidepanel-input-group'>
                    <input type='range' id='limit' name='limit' min='1' max='100' value='1'/>
                    {{-- <label id='limitAmount' for='limit'>Limit (10)</label> --}}
                  </div>
                  <fieldset id="geoBiasPanel">
                    <legend>Geo Bias:
                      <input type='checkbox' id='geoBias' name='geoBias' checked/>
                    </legend>
                    <div id='radiusParam' class='sidepanel-input-group'>
                      <input type='range' id='radius' name='radius' title='Radius value.' min='0' max='10000' value='0' />
                      <label id='radiusLabel' for='radius'>Radius (0)</label>
                    </div>
                    <div class='sidepanel-input-group' id='latParamElement'>
                      <input type='text' id='latParam' name='position' placeholder='Lat value' pattern='((-?\d*(\.\d+)?))' title='must contain position value, e.g.: 37.553'
                      value='51.4912345' />
                      <label for='latParam'>Latitude</label>
                    </div>
                    <div class='sidepanel-input-group' id='lonParamElement'>
                      <input type='text' id='lonParam' name='position' placeholder='Lon value' pattern='((-?\d*(\.\d+)?))' title='must contain position value, e.g.: -122.453'
                      value='-0.1212345' />
                      <label for='lonParam'>Longitude</label>
                    </div>
                    <div class='sidepanel-input-group geo-bias-message'>
                      <span id='geoBiasMessage'></span>
                    </div>
                  </fieldset>
                </div>
                <input type='submit' id='tomtom-example-submit' value='Submit'/>
              </form>
            </div>
            <div id='map' style='height:500px;width:500px' class='flex-expand'></div>
          </div>
          <script>
          (function(tomtom) {

            // Define your product name and version
            tomtom.setProductInfo('progettoClasse3', '2');
            // Setting TomTom keys
            tomtom.searchKey('A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh');

            // Creating map
            var map = tomtom.L.map('map', {
              key: 'A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh',
              source: 'vector',
              basePath: '/sdk',
            });



            var languageSelector = tomtom.languageSelector.getHtmlElement(new tomtom.localeService(), 'search');
            // var langParam = document.getElementById('langParam');
            // langParam.insertBefore(languageSelector, langParam.firstChild);


            // We will show results here
            var resultsList = tomtom.resultsList()
            .addTo(map);


            var markersLayer = L.tomTomMarkersLayer().addTo(map);
            var latInput = document.getElementById('latParam');
            var lonInput = document.getElementById('lonParam');
            //var limit = document.getElementById('limit');
            var radius = document.getElementById('radius');
            var geoBias = document.getElementById('geoBias');

            function handleRangeUpdate() {
              document.getElementById('radiusLabel').innerHTML = 'Radius (' + radius.value + ' m)';
              //document.getElementById('limitAmount').innerHTML = 'Limit (' + limit.value + ')';
            }

            //limit.onchange = handleRangeUpdate;
            radius.onchange = handleRangeUpdate;

            function enableGeoBiasCheckbox() {
              if (!geoBias.checked) {
                geoBias.checked = true;
                turnControlOnOrOff(true);
              }
            }

            document.getElementById('geoBiasMessage').addEventListener('click', enableGeoBiasCheckbox);

            function turnControlOnOrOff(onOffFlag) {
              var visibility = 'flex';
              var geoBiasMessage = '';

              if (!onOffFlag) {
                visibility = 'none';
                geoBiasMessage = 'Geo Bias is turned off';
              }

              document.getElementById('radiusParam').style.display = visibility;
              document.getElementById('latParamElement').style.display = visibility;
              document.getElementById('lonParamElement').style.display = visibility;
              document.getElementById('geoBiasMessage').innerText = geoBiasMessage;
            }

            geoBias.addEventListener('click', function() {
              turnControlOnOrOff(geoBias.checked);
            });


            // Submit button click handler

             document.getElementById('tomtom-example-submit').onclick = function() {


              clear();
              var options = getOptions();
              if (!options) {
                return true;
              }

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

                  drawSearchCenterMarker();
                  map.fitBounds(markersLayer.getBounds());
                } else {
                  resultsList.setContent('Results not found.');
                }
              });
              return false;
            };

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
            * Draw search center position
            */
            function drawSearchCenterMarker() {
              if (!geoBias.checked) {
                return;
              }

              var currentLocation = getInputLatLng();
              var markerOptions = {
                title: 'Search Center\nLatitude: ' + currentLocation[0] +
                '\nLongitude: ' + currentLocation[1],
                icon: tomtom.L.icon({
                  iconUrl: '/sdk/../img/center_marker.svg',
                  iconSize: [24, 24],
                  iconAnchor: [12, 12]
                })
              };

              markersLayer.addLayer(tomtom.L.marker([currentLocation[0], currentLocation[1]], markerOptions)).addTo(map);
            }

            /*
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
              latInput.value = center.lat.toFixed(7);
              lonInput.value = center.lng.toFixed(7);
            });

            map.on('zoomend', function() {
              var center = map.getCenter();
              latInput.value = center.lat.toFixed(7);
              lonInput.value = center.lng.toFixed(7);
            });

            function getInputLatLng() {
              var coords = [latInput.value, lonInput.value];
              if (coords.length !== 2 || !isNumber(coords[0]) || !isNumber(coords[1])) {
                tomtom.messageBox({ closeAfter: 3000 }).setContent('Incorrect position!').openOn(map);
                return false;
              }
              return [coords[0].trim(), coords[1].trim()];
            }

            latInput.onchange = function() {
              var center = getInputLatLng();
              if (center) {
                map.setView(center);
              }
            };

            lonInput.onchange = function() {
              var center = getInputLatLng();
              if (center) {
                map.setView(center);
              }
            };

            function isNumber(n) {
              return !isNaN(parseFloat(n)) && isFinite(n);
            }

            /*
            * Gets entered options from form fields
            */
            function getOptions() {
              var wrapper = document.getElementById('tomtom-example-inputsWrapper');
              var inputs = wrapper.getElementsByTagName('input');
              var options = {unwrapBbox: true};
              for (var i = 0; i < inputs.length; i += 1) {
                var input = inputs[i];
                if (input.name && input.value && (input.type !== 'radio' || input.checked)) {
                  options[input.name] = input.value;
                }
              }

              var selectedLangCode = languageSelector.options[languageSelector.selectedIndex].value;

              options.language = selectedLangCode;

              if (!geoBias.checked) {
                delete options.radius;
                return options;
              }

              var center = getInputLatLng();
              if (!center) {
                return false;
              }
              options.center = {
                lat: center[0],
                lon: center[1]
              };
              return options;
            }

            /*
            * Clears markers and geocode results.
            */
            function clear() {
              resultsList.clear();
              markersLayer.clearLayers();
            }

          })(tomtom, window);
          </script>
        </body>

      <div class="barraricerca input-group mb-5">
        <input id="citta_cercata" type="text" class="form-control" placeholder="Cerca città" aria-label="Recipient's username with two button addons" aria-describedby="button-addon4" value="{{ $citta_cercata }}">
        <div class="input-group-append" id="button-addon4">
          <button id="go_search" class="btn btn-outline-secondary" type="button">Avvia la ricerca</button>
          <button id="toggle_advanced" class="btn btn-outline-secondary" type="button">Ricerca avanzata</button>
        </div>
      </div>

      <div class="filtriRicerca d-none">
        <form id="advanced_form" class="form-group">
          @csrf
          <div class="form-row">
            <div class="form-group col">
              <label for="nr_of_rooms">Numero stanze</label>
              <input type="number" name="nr_of_rooms" class="form-control" placeholder="Inserisci numero stanze">
            </div>
            <div class="form-group col">
              <label for="nr_of_beds">Numero di posti letto</label>
              <input type="number" name="nr_of_beds" class="form-control" placeholder="Inserisci numero posti letto">
            </div>
            <div class="form-group col">
              <label for="radius">Modifica raggio di ricerca in km</label>
              <input type="number" name="radius" class="form-control" placeholder="Inserisci numero chilometri">
            </div>
          </div>

          <div class="form-group">
            <label for="">Ricerca per optional appartamento</label>
          </div>
          <div class="form-row">
            @foreach ($optionals as $optional)
              <div class="form-check col">
                <input name="optional" class="form-check-input" type="checkbox" value="{{$optional->id}}" >
                <label class="form-check-label" for="defaultCheck1">
                  {{ $optional->name}}
                </label>
              </div>
            @endforeach
          </div>

          {{-- <div class="form-group">
            <input type="submit" class="form-control" value="Inizia la ricerca">
          </div> --}}
        </form>
      </div>

      <div class="container">

            <div id="risultati" class="row">

            </div>

      </div>

    </div>

  </div>
  @include('partials.handlebarsTemplates')
@endsection

@section('scripts')


  <script src="{{ asset('js/search.js') }}" charset="utf-8"></script>
@endsection
