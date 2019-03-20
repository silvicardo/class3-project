@extends('layouts.app')
@section('content')

  <div class="container">
    <div class="create_form_container row">
      <div class="col-12">

        {{-- @include('partials.errors') --}}
        <h1>Aggiungi Nuovo Appartamento</h1>
        <form class="form-group" action="{{$data['action']}}" method="{{$data['method']}}">
          @csrf
          <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" name="title" class="form-control" placeholder="Inserisci il titolo">
          </div>
          <div class="form-group">
            <label for="nr_of_rooms">Numero stanze</label>
            <input type="number" name="nr_of_rooms" class="form-control" placeholder="Inserisci numero stanze">
          </div>
          <div class="form-group">
            <label for="nr_of_beds">Numero di posti letto</label>
            <input type="number" name="nr_of_beds" class="form-control" placeholder="Inserisci numero posti letto">
          </div>
          <div class="form-group">
            <label for="nr_of_bathrooms">Numero di bagni</label>
            <input type="number" name="nr_of_bathrooms" class="form-control" placeholder="Inserisci numero bagni">
          </div>
          <div class="form-group">
            <label for="mq">Metri quadrati</label>
            <input type="number" name="mq" class="form-control" placeholder="Inserisci numero posti letto">
          </div>
          <div class="form-group">
            <label for="address">Indirizzo</label>
            <input type="text" name="address" class="form-control" placeholder="Inserisci numero posti letto">
          </div>
          <div class="form-group">
            <label for="description">Descrizione</label>
            <input type="text" name="description" class="form-control" placeholder="Inserisci descrizione">
          </div>
          <div class="form-group">
            <label for="daily_price">Descrizione</label>
            <input type="number" name="daily_price" class="form-control" placeholder="Inserisci prezzo giornaliero">
          </div>
          <div class="form-group">
            <label for="">Immagine</label>
            <input type="text" name="image_url" placeholder="Inserisci l'immagine del tuo appartamento" class="form-control">
          </div>

          <div class="form-group">
            <input type="submit" class="form-control" value="Salva Appartamento">
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
