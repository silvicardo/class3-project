

@extends('layouts.app')

@section('content')

  @php
    $userPassedApartment = (!empty($selectedApartment))
  @endphp
  <div class="container">
    <div class="sponsor p-5">
      <div class="row">
        <div class="col-12">
          {{-- BENVENUTO UTENTE --}}
          <h2 class="sponsortitle">Benvenuto {{ $owner->name }},<br>
            {{($userPassedApartment) ? 'sponsorizza appartamento '. $selectedApartment->title : 'scegli e sponsorizza un appartamento'}}</h2>

          {{-- FORM PAGAMENTO  --}}
          <form id="payment-form" method="POST" action="{{ route('owner.sponsor.store') }}">
            @csrf

            {{-- SCEGLI TIPO SPONSORIZZAZIONE --}}
            <div class="form-group">
              <h3 class="sponsorlabel">Scegli la tua sponsorizzazione:</h3>

              <select name="plan_id" value="299" class="form-control form-control-lg">
                @foreach ($plans as $plan)
                <option value="{{ $plan->id }}">{{ $plan->description }}</option>
                @endforeach
              </select>
            </div>

            {{-- SCEGLI APPARTAMENTO SE NON NE È STATO PASSATO UNO --}}
            @if(!$userPassedApartment)
            <div class="form-group">
               <h3 class="sponsorlabel">Scegli uno dei tuoi appartamenti:</h3>
               <select name="apartment_id" class="form-control form-control-lg">
                 @foreach ($owner->apartments as $apartment)
                 <option value="{{ $apartment->id }}">{{ $apartment->title }}</option>
                 @endforeach
               </select>
             </div>
           @endif

           <div id="alert_errore_token" class="container alert alert-primary d-none" role="alert">
               Errore, dropin non caricato, ricarica la pagina per riprovare
           </div>

           {{-- BOTTONE CONFERMA SCELTA APPARTAMENTO E TIPO SPONSOR --}}
            <button id="conferma_prima_di_pagare" type="button" class="btn btn-success d-none">Procedi al pagamento</button>
           {{-- BARRA CARICAMENTO LOGICA BRAINTREE --}}
            <div id="loading-braintree" class="d-none">
              <p>Mi sto connettendo al portale carta di credito</p>
              <div class="progress">
                  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0"></div>
                </div>
            </div>

            {{-- SEZIONE PAGAMENTO BRAINTREE --}}
            <div id="dropin-container">

            {{-- QUi finisce il dropin di Braintree  --}}
            </div>


            <div class="submit-btn-cnt py-5">
              <button id="payment-button" class="btn btn-primary d-none" type="submit">Paga ora</button>
            </div>
          </form>
          {{--  FINE FORM PAGAMENTO --}}


          </div>
        </div>
      </div>
    </div>

  </div>
@endsection

@section('scripts')
  <script src="{{ asset('js/sponsorAnApartment.js') }}" charset="utf-8"></script>
@endsection
