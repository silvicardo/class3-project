@extends('layouts.app')
@section('content')

  <div class="container">
    <div class="form_container row">
      <div class="col-12">
        @include('partials.error')
        <h2 class="my-4">{{ $data['h2'] }}</h2>
        <form id="form_appartamento" class="form-group" action="{{ route($data['action'], (!empty($foundApartment) ? $foundApartment : null)) }}" method="post" enctype="multipart/form-data">
          @method($data['method'])
          @csrf
          <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" name="title" class="form-control" placeholder="Inserisci il titolo" value="{{ (!empty($foundApartment)) ? $foundApartment->title : null }}">
          </div>
          <div class="form-group">
            <label for="nr_of_rooms">Numero stanze</label>
            <input type="number" name="nr_of_rooms" class="form-control" placeholder="Inserisci numero stanze" value="{{ (!empty($foundApartment)) ? $foundApartment->nr_of_rooms : null }}">
          </div>
          <div class="form-group">
            <label for="nr_of_beds">Numero di posti letto</label>
            <input type="number" name="nr_of_beds" class="form-control" placeholder="Inserisci numero posti letto" value="{{ (!empty($foundApartment)) ? $foundApartment->nr_of_beds : null }}">
          </div>
          <div class="form-group">
            <label for="nr_of_bathrooms">Numero di bagni</label>
            <input type="number" name="nr_of_bathrooms" class="form-control" placeholder="Inserisci numero bagni" value="{{ (!empty($foundApartment)) ? $foundApartment->nr_of_bathrooms : null }}">
          </div>
          <div class="form-group">
            <label for="mq">Metri quadrati</label>
            <input type="number" name="mq" class="form-control" placeholder="Inserisci numero metri quadrati" value="{{ (!empty($foundApartment)) ? $foundApartment->mq : null }}">
          </div>
          <div class="form-group">
            <label for="address">Indirizzo</label>
            <input id="indirizzo" type="text" name="address" class="form-control" placeholder="Inserisci l'indirizzo" value="{{ (!empty($foundApartment)) ? $foundApartment->address : null }}">
          </div>
          <div class="form-group">
            <label for="description">Descrizione</label>
            <input type="text" name="description" class="form-control" placeholder="Inserisci descrizione" value="{{ (!empty($foundApartment)) ? $foundApartment->description : null }}">
          </div>
          <div class="form-group">
            <label for="daily_price">Prezzo</label>
            <input type="number" name="daily_price" class="form-control" placeholder="Inserisci prezzo giornaliero" value="{{ (!empty($foundApartment)) ? $foundApartment->daily_price : null }}">
          </div>

          <label for="">Scegli gli optional del tuo appartamento</label>
          @foreach ($data['availableOptionals'] as $optional)
            <div class="form-check mb-3">
              @if($data['action'] === 'apartment.update')
              <input name="optionals[]" class="form-check-input" value="{{ $optional->id }}" {{ (!empty(in_array($optional->id, $data['apartmentOptionalsIds']))) ? 'checked' : '' }} type="checkbox" >
            @else
              <input name="optionals[]" class="form-check-input" value="{{ $optional->id }}" type="checkbox" >
            @endif
              <label class="form-check-label" for="defaultCheck1">
                {{ $optional->name }}
              </label>
            </div>
          @endforeach

          <div class="form-group">
            <label for="image_url">Scegli l'immagini del tuo appartamento</label>
            <br>
            <input type="file" name="image_url">
          </div>
          <div class="form-group">
            <input type="hidden" id="input_lat" name="latitude" value="">
            <input type="hidden" id="input_lon" name="longitude" value="">
          </div>
          <div class="form-group">
            <button id="submit_form_appartamento" type="submit" class="form-control mt-5">{{ $data['button']}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>

  var tomtom = tomtom;

  console.log(tomtom);
  </script>


  <script src="{{ asset('js/findLatLon.js') }}" charset="utf-8"></script>
@endsection
