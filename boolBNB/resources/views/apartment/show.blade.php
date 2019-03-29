@extends('layouts.app')
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
       <span>
         <strong>Optionals:</strong><br>
       </span>
       <ul>
       @foreach ($foundApartment->optionals as $optional)
        <li>{{ $optional->name}}</li>
       @endforeach
       </ul>
       <span>
         <strong>Indirizzo:</strong> <span id="indirizzo">{{ $foundApartment->address }}</span>
       </span>
       <div class="d-none" id="latitudine">
          {{ $foundApartment->latitude}}
       </div>
       <div class="d-none" id="longitudine">
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
           <a id="mostraMappa" href="#">Mostra Mappa <i class="fas fa-arrow-circle-down mt-3"></i></a>
           <a id="nascondiMappa" class="d-none" href="#">Nascondi Mappa <i class="fas fa-arrow-circle-up mt-3"></i></a>
         </div>
       @else
         <a id="mostraMappa" href="#">Mostra Mappa <i class="fas fa-arrow-circle-down mt-3 mr-5"></i></a>
         <a id="nascondiMappa" class="d-none" href="#">Nascondi Mappa <i class="fas fa-arrow-circle-up mt-3 mr-5"></i></a>
         <a id="mostraForm" href="#">Richiedi Informazioni <i class="fas fa-arrow-circle-down mt-3"></i></a>
         <a id="nascondiForm" class="d-none" href="#">Chiudi informazioni <i class="far fa-times-circle mt-3"></i></a>
         <div id="form" class="d-none">
           <h2 class="my-5">Richiedi informazioni al proprietario su questo appartamento</h2>
           <form action="{{route('messages.store')}}" method="post">
             @csrf
             @method('POST')
             <input type="hidden" name="apartment_id" value="{{$foundApartment->id}}">
             <div class="form-group">
               <label for="name">Nome</label>
               <input type="text" name="name" class="form-control" value="{{ (!empty($user)) ? $user->name : '' }}" placeholder="Inserisci il tuo nome">
             </div>
             <div class="form-group">
               <label for="email">Email mittente</label>
               <input type="email" name="email" class="form-control" value="{{ (!empty($user)) ? $user->email : '' }}" placeholder="name@example.com">
             </div>
             <div class="form-group">
               <label for="subject">Oggetto messaggio</label>
               <input type="text" name="subject" class="form-control" value="" placeholder="Oggetto del messaggio">
             </div>
             <div class="form-group">
               <label for="description_body">Messaggio</label>
               <textarea class="form-control" name="description_body" placeholder="Inserisci il tuo messaggio" rows="3"></textarea>
             </div>
             <button type="submit" class="btn btn-primary">Invia</button>
           </form>
         </div>




      @endif

     </div>
     <div id="mapContainer" class="d-none">
       <div class='use-all-space my-5'>
          <div class='flex-horizontal use-all-space'>
             <div id='map' style='height:500px;width:500px' class='flex-expand'></div>

          </div>

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
