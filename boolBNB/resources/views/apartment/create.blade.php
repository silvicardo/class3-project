@extends('layouts.app')
@section('content')

  <div class="container">
    <div class="form_container row">
      <div class="col-12">
        @include('partials.error')
        <h2 class="my-4">Aggiungi Nuovo Appartamento</h2>
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
            <input type="number" name="mq" class="form-control" placeholder="Inserisci numero metri quadrati">
          </div>
          <div class="form-group">
            <label for="address">Indirizzo</label>
            <input type="text" name="address" class="form-control" placeholder="Inserisci l'indirizzo">
          </div>
          <div class="form-group">
            <label for="description">Descrizione</label>
            <input type="text" name="description" class="form-control" placeholder="Inserisci descrizione">
          </div>
          <div class="form-group">
            <label for="daily_price">Prezzo</label>
            <input type="number" name="daily_price" class="form-control" placeholder="Inserisci prezzo giornaliero">
          </div>


          <label for="">Scegli gli optional del tuo appartamento</label>

          <div class="form-check mb-3">
            <input name="optional" class="form-check-input" type="checkbox" value="">

            <label class="form-check-label" for="defaultCheck1">
              Wifi
            </label>
          </div>

          <div class="form-check mb-3">
            <input name="optional" class="form-check-input" type="checkbox" value="">
            <label class="form-check-label" for="defaultCheck1">
              Posto macchina
            </label>
          </div>

          <div class="form-check mb-3">
            <input name="optional" class="form-check-input" type="checkbox" value="">

            <label class="form-check-label" for="defaultCheck1">
              Piscina
            </label>
          </div>

          <div class="form-check mb-3">
            <input name="optional" class="form-check-input" type="checkbox" value="">

            <label class="form-check-label" for="defaultCheck1">
              Portineria
            </label>
          </div>

          <div class="form-check mb-3">
            <input name="optional" class="form-check-input" type="checkbox" value="">

            <label class="form-check-label" for="defaultCheck1">
              Vista mare
            </label>
          </div>

          <div class="form-check mb-3">
            <input name="optional" class="form-check-input" type="checkbox" value="">

            <label class="form-check-label" for="defaultCheck1">
              Sauna
            </label>
          </div>

          {{-- <div class="form-group">
            <label for="image_url">Scegli le immagini del tuo appartamento</label>
            <br>
            <input type="file" name="image_url">
          </div> --}}
          <div class="form-group">
            <label for="image_url">Immagine Text Provvisoria</label>
            <input type="text" name="image_url" class="form-control" placeholder="Immagine Text Provvisoria">
          </div>

          <div class="form-group">
            <input type="submit" class="form-control mt-5" value="Salva Appartamento">
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
