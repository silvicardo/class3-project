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

      {{-- inizio mappa --}}
      <link rel='stylesheet' type='text/css' href="{{ asset('sdk/map.css')}}"/>
      <script src="{{ asset('sdk/tomtom.min.js') }}"></script>
      <div id='map' style='height:500px;width:500px'></div>
        <script>
    	    tomtom.setProductInfo('progettoClasse3', '2');
          tomtom.L.map('map', {
		        key: 'A8p4RHYLPVFkmdSk3a0acLxVQKvCJNzh',
            center: [37.769167, -122.478468],
            source: 'vector',
            basePath: '/sdk',
            zoom: 15
    	    });
        </script>

      <div class="barraricerca input-group mb-5">
        <input id="citta_cercata" type="text" class="form-control" placeholder="Cerca città" aria-label="Recipient's username with two button addons" aria-describedby="button-addon4" value="{{ $citta_cercata }}">
        <div class="input-group-append" id="button-addon4">
          <button id="go_search" class="btn btn-outline-secondary" type="button">Avvia la ricerca</button>
          <button id="toggle_advanced" class="btn btn-outline-secondary" type="button">Ricerca avanzata</button>
        </div>
      </div>

      <div class="filtriRicerca d-none">
        <form id="advanced_form" class="form-group">
          @csrf
          <div class="form-row">
            <div class="form-group col">
              <label for="nr_of_rooms">Numero stanze</label>
              <input type="number" name="nr_of_rooms" class="form-control" placeholder="Inserisci numero stanze">
            </div>
            <div class="form-group col">
              <label for="nr_of_beds">Numero di posti letto</label>
              <input type="number" name="nr_of_beds" class="form-control" placeholder="Inserisci numero posti letto">
            </div>
            <div class="form-group col">
              <label for="radius">Modifica raggio di ricerca in km</label>
              <input type="number" name="radius" class="form-control" placeholder="Inserisci numero chilometri">
            </div>
          </div>

          <div class="form-group">
            <label for="">Ricerca per optional appartamento</label>
          </div>
          <div class="form-row">
            @foreach ($optionals as $optional)
              <div class="form-check col">
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

            <div id="risultati" class="row">

            </div>

      </div>

    </div>

  </div>
  @include('partials.handlebarsTemplates')
@endsection

@section('scripts')


  <script src="{{ asset('js/search.js') }}" charset="utf-8"></script>
@endsection
