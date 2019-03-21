

@extends('layouts.app')

@section('content')


  <div class="container">
    <div class="sponsor">
      <div class="row">
        <div class="col-12">
          <h2 class="sponsortitle">Benvenuto {{ $owner->name }}, sponsorizza il tuo appartamento {{ $apartment->title}} </h2>

          <form class="form-group">
            <h3 class="sponsorlabel">Scegli la tua sponsorizzazione:</h3>
            @foreach ($plans as $plan)
              <div class="form-check">
                <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                <label class="form-check-label" for="exampleRadios1">
                  {{ $plan->name}}
                </label>
              </div>
            @endforeach
          </form>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection
