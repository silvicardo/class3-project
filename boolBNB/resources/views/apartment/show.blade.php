@extends('layouts.app')

@section('content')

<div class="container">
  <div class="showcardcontainer">
    <div class="card" style="width: 40rem;">
     <img class="card-img-top" src="{{ $foundApartment->image_url}}" alt="Card image cap">
     <div class="card-body">
       <h5 class="card-title">Card title</h5>
       <p class="card-text">{{ $foundApartment->description}}</p>
       <span>Numero stanze: {{ $foundApartment->nr_of_rooms}}</span><br>
       <span>Numero posti letto: {{ $foundApartment->nr_of_beds}}</span><br>
       <span>Numero bagni: {{ $foundApartment->nr_of_bathrooms}}</span><br>
       <span>Metri quadrati: {{ $foundApartment->mq }}</span><br>
       <span>Indirizzo: {{ $foundApartment->address }}</span><br>
       <h2>Richiedi informazioni al proprietario</h2>

       
     </div>

    </div>
  </div>

</div>


@endsection
