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

       <hr>
       <h2>Richiedi informazioni al proprietario su questo appartamento</h2>
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

     </div>

    </div>
  </div>

</div>


@endsection
