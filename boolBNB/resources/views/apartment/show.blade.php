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
     </div>

    </div>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">Example textarea</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>


    @if (!empty(Auth::user()) && Auth::user()->can('edit-apartment'))
      <a class="btn btn-secondary btn-lg" href="{{ route('apartment.edit', $foundApartment->id)}}">Edita appartamento</a>
    @endif
  @if (!empty(Auth::user()) && Auth::user()->can('delete-apartment'))
    <form action="{{ "/apartment/" . $foundApartment->id . "/delete"}}" method="POST">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-danger">Delete</button>
     </form>

  @endif
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-5">
      <div class="card" style="width: 18rem;">
        <div class="card_user">
          <img class="img_user card-img-top" src="{{ asset('img/avatar1.png') }}" alt="Card image cap">
        </div>
        <div class="card-body">
          <h5 class="card-title">"User"</h5>
          <h6 class="card-title">"Email"</h6>
          <h6 class="card-title">"Registrato il"</h6>
        </div>
      </div>
    </div>
    <div class="col-sm-7">
      <div class="container_profile">
        <div class="container_profile_edit">
          <h2>Ciao, Massmiliano</h2>
          <a href="#">Modifica profilo</a>
        </div>
        <div class="container_profile_delete">
          <form action="#" method="POST">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="btn btn-danger">Elimina il tuo account</button>
           </form>
        </div>

      </div>

    </div>
  </div>
</div>

@endsection
