

@extends('layouts.app')

@section('content')


  <div class="container">
    <div class="sponsor p-5">
      <div class="row">
        <div class="col-12">
          <h2 class="sponsortitle">Benvenuto {{ $owner->name }},<br>sponsorizza il tuo appartamento<br> {{ $apartment->title}} </h2>
          <form >
            <div class="form-group">
              <h3 class="sponsorlabel">Scegli la tua sponsorizzazione:</h3>
              <select class="form-control form-control-lg">
                @foreach ($plans as $plan)
                <option value="{{ $plan->slug }}">{{ $plan->description }}</option>
                @endforeach
              </select>
            </div>
            <div id="dropin-container">
              {{-- QUi finisce il dropin di Braintree  --}}
            </div>
            {{-- Da attivare quando il seeder sarà pronto, per ora appartamento da url --}}
            {{-- <div class="form-group">
              <h3 class="sponsorlabel">Scegli uno dei tuoi appartamenti:</h3>
              <select class="form-control form-control-lg">
                @foreach ($ownerApartments as $apartment)
                <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
                @endforeach
              </select>
            </div> --}}

          </form>

          </div>
        </div>
      </div>
    </div>

  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/sponsorAnApartment.js') }}" charset="utf-8"></script>
@endsection
