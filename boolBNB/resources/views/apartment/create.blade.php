@extends('layouts.app')
@section('content')

  <div class="container">
    <div class="create_form_container row">
      <div class="col-12">
        @include('partials.error')
        <h1>Aggiungi Nuovo Appartamento</h1>
        <form class="form-group" action="" method="post">
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
            <input type="numeber" name="mq" class="form-control" placeholder="Inserisci numero posti letto">
          </div>
          <div class="form-group">
            <label for="address">Indirizzo</label>
            <input type="text" name="address" class="form-control" placeholder="Inserisci numero posti letto">
          </div>
          <div class="form-group">
            <label for="image_url">Scegli le immagini del tuo appartamento</label>
            <br>
            <input type="file" name="image_url">
          </div>

          <div class="form-group">
            <input type="submit" class="form-control" value="Salva Appartamento">
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
