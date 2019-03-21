

@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="sponsor">
      <div class="row">
        <div class="col-12">
          <h2 class="sponsortitle">Benvenuto, sponsorizza il tuo appartamento: {{-- inserire variabile titolo appartamento --}} </h2>


          <form class="form-group">
            <label class="sponsorlabel" for="">Scegli la modalita della tua sponsorizzazione:</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
              <label class="form-check-label" for="exampleRadios1">
                2,99 € per 24 ore di sponsorizzazione
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
              <label class="form-check-label" for="exampleRadios1">
                5.99 € per 72 ore di sponsorizzazione
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
              <label class="form-check-label" for="exampleRadios1">
                9.99 € per 144 ore di sponsorizzazione
              </label>
            </div>

          </form>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection
