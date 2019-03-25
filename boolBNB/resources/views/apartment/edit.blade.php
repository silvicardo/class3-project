@extends('layouts.app')
@section('content')

  <div class="container">
    <div class="form_container row">
      <div class="col-12">
        @include('partials.error')
        <h1>Modifica Appartamento</h1>
        <form class="form-group" action="{{ $data['action']}}" method="post">
          @method('PUT')
          @csrf
          <input type="hidden" name="user_id" value="{{ $foundApartment->user_id}}">

          <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" name="title" class="form-control"  value="{{ $foundApartment->title }}" placeholder="Inserisci il titolo">
          </div>
          <div class="form-group">
            <label for="nr_of_rooms">Numero stanze</label>
            <input type="number" name="nr_of_rooms" class="form-control" value="{{ $foundApartment->nr_of_rooms }}" placeholder="Inserisci numero stanze">
          </div>
          <div class="form-group">
            <label for="nr_of_beds">Numero di posti letto</label>
            <input type="number" name="nr_of_beds" class="form-control" value="{{ $foundApartment->nr_of_beds }}" placeholder="Inserisci numero posti letto">
          </div>
          <div class="form-group">
            <label for="nr_of_bathrooms">Numero di bagni</label>
            <input type="number" name="nr_of_bathrooms" class="form-control" value="{{ $foundApartment->nr_of_bathrooms }}" placeholder="Inserisci numero bagni">
          </div>
          <div class="form-group">
            <label for="mq">Metri quadrati</label>
            <input type="number" name="mq" class="form-control" value="{{ $foundApartment->mq }}" placeholder="Inserisci numero metri quadrati">
          </div>
          <div class="form-group">
            <label for="address">Indirizzo</label>
            <input type="text" name="address" class="form-control" value="{{ $foundApartment->address }}" placeholder="Inserisci l'indirizzo">
          </div>
          <div class="form-group">
            <label for="description">Descrizione</label>
            <input type="text" name="description" class="form-control" value="{{ $foundApartment->description }}" placeholder="Inserisci descrizione">
          </div>
          <div class="form-group">
            <label for="daily_price">Prezzo</label>
            <input type="number" name="daily_price" class="form-control" value="{{ $foundApartment->daily_price }}" placeholder="Inserisci prezzo giornaliero">
          </div>
          <label for="">Scegli gli optional del tuo appartamento</label>

          @foreach($data['availableOptionals'] as $optional)
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="{{ $optional->name }}"
            value="{{ $optional->id }}" {{ (in_array($optional->id, $foundApartment->optionals()->get()->toArray())) ? 'checked="checked"' : '' }} >
            <label class="form-check-label" for="defaultCheck1">
              {{ $optional->name }}
            </label>
          </div>


          @endforeach

          {{-- <div class="form-group">
            <label for="image_url">Scegli le immagini del tuo appartamento</label>
            <br>
            <input type="file" name="image_url">
          </div> --}}
          <div class="form-group">
            <label for="image_url">Immagine Text Provvisoria</label>
            <input type="text" name="image_url" class="form-control" value="{{ $foundApartment->image_url }}"  placeholder="Inserisci il titolo">
          </div>

          <div class="form-group">
            <input type="submit" class="form-control" value="Salva modifiche appartamento">
          </div>
        </form>
      </div>
    </div>
  </div>



@endsection
