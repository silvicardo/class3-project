@extends('layouts.app')

@section('content')
  <div class="container">

    <div class="progressBar">
      <div id="loading-search">
        <p>Sto caricando la ricerca</p>
        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
        </div>
      </div>
    </div>

    <div class="ho_caricato">
      <div class="barraricerca">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Cerca città" aria-label="Recipient's username with two button addons" aria-describedby="button-addon4">
        <div class="input-group-append" id="button-addon4">
          <button class="btn btn-outline-secondary" type="button">Avvia la ricerca</button>
          <button class="btn btn-outline-secondary" type="button">Ricerca avanzata</button>
        </div>
      </div>
        <form class="form-group" action="#" method="#">
          @csrf
          <div class="form-group">
            <label for="nr_of_rooms">Numero stanze</label>
            <input type="number" name="nr_of_rooms" class="form-control" placeholder="Inserisci numero stanze">
          </div>
          <div class="form-group">
            <label for="nr_of_beds">Numero di posti letto</label>
            <input type="number" name="nr_of_beds" class="form-control" placeholder="Inserisci numero posti letto">
          </div>
          <div class="form-group">
            <label for="">Modifica raggio di ricerca in km</label>
            <input type="number" name="" class="form-control" placeholder="Inserisci numero chilometri">
          </div>
          <label for="">Ricerca per optional appartamento</label>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Wifi
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Posto macchina
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Piscina
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Portineria
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Vista mare
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
              Sauna
            </label>
          </div>
          <div class="form-group">
            <input type="submit" class="form-control" value="Inizia la ricerca">
          </div>
        </form>
      </div>
      <div class="filtriRicerca">

      </div>
      <div id="risultati">
        <div class="risultato template">
          {{-- <script id="entry-template" type="text/x-handlebars-template">
                <div class="entry">
                <h1>{{title}}</h1>
                <div class="body">
                {{body}}
              </div>
            </div>
          </script> --}}
          <div class="container">
            <div class="row">
                <div class="card_appartment col-md-4 mt-5">
                  <a href="{{--{{route('apartment.show', $apartment->id) }}--}}">
                    <div class="card">
                     <img class="card-img-top" src="{{--{{ $apartment->image_url}}--}}" alt="Card image cap">
                     <div class="card-body">
                       <h5 class="card-title">{{--{{ $apartment->title }}--}}</h5>
                       <p class="card-text">{{--{{ $apartment->description}}--}}</p>
                     </div>
                    </div>
                  </a>
                </div>
            </div>

        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/search.js') }}" charset="utf-8"></script>
@endsection
