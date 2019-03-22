

@extends('layouts.app')

@section('content')


  <div class="container">
    <div class="sponsor p-5">
      <div class="row">
        <div class="col-12">
          <h2 class="sponsortitle">Benvenuto {{ $owner->name }},<br>sponsorizza il tuo appartamento<br> {{ $apartment->title}} </h2>
          <form id="payment-form" method="POST" action="{{ route('owner.sponsor.store') }}">
            @csrf
            <div class="form-group">
              <h3 class="sponsorlabel">Scegli la tua sponsorizzazione:</h3>
              <select name="plan_id" value="299" class="form-control form-control-lg">
                @foreach ($plans as $plan)
                <option value="{{ $plan->id }}">{{ $plan->description }}</option>
                @endforeach
              </select>
            </div>
            <div id="loading-braintree">
              <p>Mi sto connettendo al portale carta di credito</p>
              <div class="progress">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
                </div>
            </div>
            <div id="dropin-container">
              {{-- QUi finisce il dropin di Braintree  --}}
            </div>
            {{-- Da attivare quando il seeder sarà pronto, per ora appartamento da url --}}
            {{-- <div class="form-group">
              <h3 class="sponsorlabel">Scegli uno dei tuoi appartamenti:</h3>
              <select name="apartment_id" class="form-control form-control-lg">
                @foreach ($ownerApartments as $apartment)
                <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
                @endforeach
              </select>
            </div> --}}
            <div class="submit-btn-cnt py-5">
              <button id="payment-button" class="btn btn-primary d-none" type="submit">Paga ora</button>
            </div>
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
