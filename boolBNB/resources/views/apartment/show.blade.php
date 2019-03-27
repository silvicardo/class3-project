@extends('layouts.app')

@section('content')
<div class="container">
  <div class="showcardcontainer mt-5">
    <div class="card" style="width: 40rem;">
     <img class="card-img-top" src="{{ $foundApartment->image_url}}" alt="Card image cap">
     <div class="card-body">
       <h5 class="card-title">Card title</h5>
       <p class="card-text">{{ $foundApartment->description}}</p>
       <span><strong>Numero stanze:</strong> {{ $foundApartment->nr_of_rooms}}</span><br>
       <span><strong>Numero posti letto:</strong> {{ $foundApartment->nr_of_beds}}</span><br>
       <span><strong>Numero bagni:</strong> {{ $foundApartment->nr_of_bathrooms}}</span><br>
       <span><strong>Metri quadrati:</strong> {{ $foundApartment->mq }}</span><br>
       <span id="indirizzo">{{ $foundApartment->address }}</span>
       <div id="latitudine">
          {{ $foundApartment->latitude}}
       </div>
       <div id="longitudine">
          {{ $foundApartment->longitude}}
       </div>

       <hr>
       @php
       $user = Auth::user();
       @endphp
      @if($user !== null && $user->can('manage-owner') && $user->id === $foundApartment->user_id)
         <div class="comandi_appartamento">
          <a href="{{ route('owner.sponsor.create',$foundApartment)}}" class="btn btn-warning text-white">Sponsorizza appartamento</a>
           <a class="btn btn-primary" href="{{ route('apartment.edit', $foundApartment->id)}}">Modifica appartamento</a>

           <form action="{{ route('apartment.destroy', $foundApartment->id)}}" class="d-inline-block" method="POST">
             @method('DELETE')
             @csrf
             <button type="submit" class="btn btn-danger delete">Rimuovi appartamento</button>
           </form>
         </div>
       @else
         <h2 class="my-5">Richiedi informazioni al proprietario su questo appartamento</h2>
         <form action="#" method="post">
           @csrf
           @method('POST')
           <div class="form-group">
             <label for="name">Nome</label>
             <input type="text" name="name" class="form-control" {{--value="{{ $guest->name }}"--}} placeholder="Inserisci il tuo nome">
           </div>
           <div class="form-group">
             <label for="email">Email</label>
             <input type="email" name="email" class="form-control" {{--value="{{ $guest->email }}"--}} placeholder="name@example.com">
           </div>
           <div class="form-group">
             <label for="message">Messaggio</label>
             <textarea class="form-control" name="message" placeholder="Inserisci il tuo messaggio" rows="3"></textarea>
           </div>
           <button type="submit" class="btn btn-primary">Invia</button>
         </form>
      @endif
     </div>

    </div>
  </div>

</div>

<body class='use-all-space'>
         <div class='flex-horizontal use-all-space'>

           <div id='map' style='height:500px;width:500px' class='flex-expand'></div>
         </div>
          <script     src="http://code.jquery.com/jquery-3.3.1.min.js"     integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="     crossorigin="anonymous"></script>
         <script>
         (function(tomtom) {
           // // Define your product name and version
           // tomtom.setProductInfo('progettoClasse3', '2');
           // // Setting TomTom keys
           // tomtom.searchKey('A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh');
           // Creating map
           var map = tomtom.L.map('map', {
             key: 'A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh',
             source: 'vector',
             basePath: '/sdk',
             zoom: 16
           });
           // We will show results here
           var resultsList = tomtom.resultsList()
           .addTo(map);
           var markersLayer = L.tomTomMarkersLayer().addTo(map);

             clear();
             var options = {
               language:  'it-IT',
               unwrapBbox: true,
               query: $('#indirizzo').html(),

               limit: "1",
               radius: "0",
               center: { lat: parseFloat($('#latitudine').html()), lon: parseFloat($('#longitudine').html())},
               geoBias: "on",
               position: parseFloat($('#longitudine').html()),

             }

            console.log(options);



             tomtom.geocode(options).go(function(geoResponses) {
               console.log('risposta', geoResponses);

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
                 // var center = getInputLatLng();
                 // var centerObj = {lat: center[0],
                 //     lon: center[1]
                 //   };
                 //  console.log(center);
                 //  debugger
                 //  map.setView(center)


                 // drawSearchCenterMarker();
                 // debugger

                 map.fitBounds(markersLayer.getBounds());
               } else {
                 console.log('errore');
                 debugger
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
           * Draw search center position
           */
           function drawSearchCenterMarker() {

             var currentLocation = getInputLatLng();

             var markerOptions = {
               title: 'Search Center\nLatitude: ' + 43.7131812 +
               '\nLongitude: ' + 10.9359877,
               icon: tomtom.L.icon({
                 iconUrl: './center_marker.svg', //'/sdk/../img/center_marker.svg'
                 iconSize: [24, 24],
                 iconAnchor: [12, 12]
               })

             };
             console.log(markerOptions);
             markersLayer.addLayer(tomtom.L.marker([43.7131812, 10.9359877], markerOptions)).addTo(map);
             debugger
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
             // latInput.value = center.lat.toFixed(7);
             // lonInput.value = center.lng.toFixed(7);
           });
           map.on('zoomend', function() {
             var center = map.getCenter();
             console.log(center);
             // latInput.value = center.lat.toFixed(7);
             // lonInput.value = center.lng.toFixed(7);
           });
           function getInputLatLng() {
             var coords = [43.7131812, 10.9359877];
             if (coords.length !== 2 || !isNumber(coords[0]) || !isNumber(coords[1])) {
               tomtom.messageBox({ closeAfter: 3000 }).setContent('Incorrect position!').openOn(map);
               return false;
             }
             return [coords[0].trim(), coords[1].trim()];
           }
           // latInput.onchange = function() {
           //   var center = getInputLatLng();
           //   if (center) {
           //     map.setView(center);
           //   }
           // };
           // lonInput.onchange = function() {
           //   var center = getInputLatLng();
           //   if (center) {
           //     map.setView(center);
           //   }
           // };
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
             console.log(options);
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





 </div>


@endsection
@section('scripts')
  <script>



  var tomtom = tomtom;
  </script>


  {{-- <script src="{{ asset('js/show.js') }}" charset="utf-8"></script> --}}
@endsection
