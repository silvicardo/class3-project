@extends('layouts.app')

@section('content')
  <div class="container py-5">


    <div id="sto_caricando" class="d-none">

        <p>Sto caricando la ricerca</p>

        <div class="progress">
          <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
        </div>

    </div>

    <div id="ho_caricato">

      {{-- <div class="barraricerca input-group mb-5">
        <input id="citta_cercata" type="text" class="form-control" placeholder="Cerca città" aria-label="Recipient's username" aria-describedby="button-addon2" value="{{ $citta_cercata }}">
        <div class="input-group-append" id="button-addon4">
          <button id="go_search" class="btn btn-outline-secondary" type="button">Avvia la ricerca</button>
          <button id="toggle_advanced" class="btn btn-outline-secondary" type="button">Ricerca avanzata</button>
        </div>
      </div> --}}
      <div class="barraricerca input-group mb-5">
        <input id="citta_cercata" type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2" value="{{ $citta_cercata }}">
        <div class="input-group-append">
          <button id="go_search" class="btn btn-outline-secondary" type="button">Ricerca</button>
          <button id="toggle_advanced" class="btn btn-outline-secondary" type="button">Avanzata</button>
        </div>
      </div>

      <div class="filtriRicerca d-none">
        <form id="advanced_form" class="form-group">
          @csrf
          <div class="form-row">
            <div class="form-group col-sm-6">
              <label for="radius">Raggio (Km)</label>
              <input type="number" name="radius" class="form-control" placeholder="Numero chilometri">
            </div>
            <div class="form-group col-sm-6">
              <label for="nr_of_rooms">Numero stanze</label>
              <input type="number" name="nr_of_rooms" class="form-control" placeholder="Numero stanze">
            </div>
            <div class="form-group col-sm-6">
              <label for="nr_of_beds">Numero posti letto</label>
              <input type="number" name="nr_of_beds" class="form-control" placeholder="Numero posti letto">
            </div>
            <div class="form-group col-sm-6">
              <label for="nr_of_bathrooms">Numero bagni</label>
              <input type="number" name="nr_of_bathrooms" class="form-control" placeholder="Numero bagni">
            </div>

          </div>

          <div class="form-group mt-4">
            <label for="">Ricerca per optional appartamento:</label>
          </div>
          <div class="form-row">
            @foreach ($optionals as $optional)
              <div class="form-check col-md-3 ml-4 mt-4">
                <input name="optional" class="form-check-input" type="checkbox" value="{{$optional->id}}" >
                <label class="form-check-label" for="defaultCheck1">
                  {{ $optional->name}}
                </label>
              </div>
            @endforeach
          </div>

          {{-- <div class="form-group">
            <input type="submit" class="form-control" value="Inizia la ricerca">
          </div> --}}
        </form>
      </div>

      <div class="container">

            <div id="risultati" class="row mt-5">

            </div>

      </div>

    </div>

  </div>
  @include('partials.handlebarsTemplates')
@endsection

@section('scripts')
  <script>



  var ciao = 'eccomi';
  var tomtom = tomtom;
  </script>


  <script src="{{ asset('js/search.js') }}" charset="utf-8"></script>
@endsection
