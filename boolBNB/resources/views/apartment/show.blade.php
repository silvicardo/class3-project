@extends('layouts.app')
{{-- PRIMA
-layout condizione inserire rotta nell’or
-creazione del file in resources/js/
-webpack
-sudo run watch
- PRENDERE IL VALORE DELL INDIRIZZO DALLA PAGINA
- CREARE OGGETTO OPZIONI
{
     language:  ‘it-IT’,
     unwrapBbox: true,
     query: $(‘#INDIRIZZO’).val(),
     limit: “1”,
     radius: “0",
     geoBias: “on”,
   }
-PASSARE OPTIONS ALLA FUNZIONE PRINCIPALE E MANEGGIARE
L’ARRAY RESPONSES CHE RITORNA
$.getJSON(‘url’, options).then(function(sondata){
});
tomtom.geocode(opzioni).go(function(responses){
    responses[0]
    //IL VOSTRO CODICE
    //far partire in quella posizione e metterla in un div
 });
in pagina blade show, inserire section(‘script’) con la var tomtom = tomtom --}}

@section('content')
<div class="container">
  <div class="showcardcontainer mt-5">
    <div class="card" style="width: 40rem;">
     <img class="card-img-top" src="{{ asset('storage/' . $foundApartment->image_url) }}" alt="Card image cap">
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
     <div class='use-all-space'>
        <div class='flex-horizontal use-all-space'>
           <div id='map' style='height:500px;width:500px' class='flex-expand'></div>

        </div>

     </div>
    </div>

  </div>

</div>


@endsection
@section('scripts')
  <script>var tomtom = tomtom;</script>

  <script src="{{ asset('js/show.js') }}" charset="utf-8"></script>

@endsection
