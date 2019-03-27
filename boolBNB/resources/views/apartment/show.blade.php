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
          
         })(tomtom, window);
         </script>
       </body>





 </div>


@endsection
@section('scripts')
  <script>



  var tomtom = tomtom;
  </script>


  <script src="{{ asset('js/show.js') }}" charset="utf-8"></script>
@endsection
